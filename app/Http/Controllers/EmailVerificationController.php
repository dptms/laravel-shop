<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Http\Request;
use Exception;

class EmailVerificationController extends Controller
{
    // 邮箱验证
    public function verify(Request $request)
    {
        // 从 url 中获取 email 和 token 两个参数
        $email = $request->input('email');
        $token = $request->input('token');
        // 如果有一个为空说明不是一个合法的验证链接，直接抛出异常。
        if (!$email || !$token) {
            throw  new InvalidRequestException('验证链接不正确');
        }
        // 从缓存中读取数据，把 url 中获取的 'token' 与缓存中的值做对比
        // 如果缓存不存在或返回的值与 url 中的 token 不一致就抛出异常。
        if ($token != cache('email_verification_' . $email)) {
            throw new InvalidRequestException('验证链接不正确或已过期');
        }
        // 根据邮箱从数据库中获取对应用户
        if (!$user = User::where('email', $email)->first()) {
            throw new InvalidRequestException('用户不存在');
        }
        // 将制定的 key 从缓存中删除，由于已经完成了验证，这个缓存就没有必要继续保留
        cache()->forget('email_verification_' . $email);
        // 最关键的，要把用户对应的 email_verified 字段改为 true
        $user->update(['email_verified' => true]);

        // 最后告知用户邮箱验证成功。
        return view('pages.success', ['msg' => '邮箱验证成功']);
    }

    // 用户主动发送激活邮件
    public function send(Request $request)
    {
        $user = $request->user();
        // 判断用户是否已经激活
        if ($user->email_verified) {
            throw new InvalidRequestException('你已验证过邮箱了');
        }
        // 调用 notify() 方法用来发送定义好的通知类
        $user->notify(new EmailVerificationNotification());

        return view('pages.success', ['msg' => '邮件发送成功']);
    }
}
