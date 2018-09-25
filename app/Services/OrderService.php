<?php

namespace App\Services;

use App\Exceptions\InternalException;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store(User $user, UserAddress $address, $remark, $items)
    {
        // 开启一个数据库事务
        $order = DB::transaction(function () use ($user, $address, $remark, $items) {
            // 更新地址最后使用时间
            $address->update(['last_used_at' => now()]);
            // 创建一个订单
            $order = new Order([
                'address' => [
                    'address' => $address->full_address,
                    'zip' => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark' => $remark,
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();

            $total_amount = 0;
            // 遍历用户提交的 SKU
            foreach ($items as $data) {
                $sku = ProductSku::find($data['sku_id']);
                // 创建一个 OrderItem 并且与当前订单关联
                $item = $order->items()->make([
                    'amount' => $data['amount'],
                    'price' => $sku->price,
                ]);
                $item->product()->associate($sku->product_id);
                $item->productSku()->associate($sku);
                $item->save();
                $total_amount += $sku->price * $data['amount'];
                if ($sku->decreaseStock($data['amount']) < 0) {
                    throw new InternalException('该商品库存不足');
                }
            }

            $order->update(['total_amount' => $total_amount]);

            // 将下单的商品从购物车中移除
            $skuIds = collect($items)->pluck('sku_id')->all();
            app(CartService::class)->remove($skuIds);

            return $order;
        });

        // 这里直接用 dispatch 函数
        dispatch(new CloseOrder($order,config('app.order_ttl')));

        return $order;
    }
}