<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Menu;
use Illuminate\Support\Facades\DB;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['parent_id' => 0, 'order' => 1, 'title' => '首页', 'icon' => 'fa-bar-chart', 'uri' => '/'],
            ['parent_id' => 0, 'order' => 2, 'title' => '系统管理', 'icon' => 'fa-tasks', 'uri' => ''],
            ['parent_id' => 2, 'order' => 3, 'title' => '管理员', 'icon' => 'fa-users', 'uri' => 'auth/users'],
            ['parent_id' => 2, 'order' => 4, 'title' => '角色', 'icon' => 'fa-user', 'uri' => 'auth/roles'],
            ['parent_id' => 2, 'order' => 5, 'title' => '权限', 'icon' => 'fa-ban', 'uri' => 'auth/permissions'],
            ['parent_id' => 2, 'order' => 6, 'title' => '菜单', 'icon' => 'fa-bars', 'uri' => 'auth/menu'],
            ['parent_id' => 2, 'order' => 7, 'title' => '日志', 'icon' => 'fa-history', 'uri' => 'auth/logs'],

            ['parent_id' => 0, 'order' => 0, 'title' => '用户管理', 'icon' => 'fa-users', 'uri' => 'users'],
            ['parent_id' => 0, 'order' => 0, 'title' => '商品管理', 'icon' => 'fa-cubes', 'uri' => 'products'],
        ];

        $menu = new Menu();
        DB::table('admin_menu')->truncate();
        foreach ($data as $item) {
            $menu->firstOrCreate($item);
        }
    }

}
