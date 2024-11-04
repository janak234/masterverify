<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->insert([
            ['name' => 'superadmin','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => 'weaving','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => 'beaming','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => 'procurement','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
        ]);

        DB::table('users')->insertGetId(
            [
            'role_id' => 1,
            'firstname'=>'Super',
            'lastname'=>'Admin',
            'mobile'=>'123123',
            'email'=>'superadmin@superadmin.com',
            'password'=>bcrypt('123123'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
            'role_id' => 2,
            'firstname'=>'weaving',
            'lastname'=>'user',
            'mobile'=>'123123',
            'email'=>'weaving@weaving.com',
            'password'=>bcrypt('123123'),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            ]
        );
        DB::table('permissions')->insertGetId(
            [
            'role_id' => 1,
            'access'=>'role,user',
            'list'=>'role,user',
            'view'=>'role,user',
            'add'=>'role,user',
            'edit'=>'role,user',
            'delete'=>'role,user',
            'search'=>'role,user',
            'status'=>'role,user',
            'export'=>'role,user',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            ]
        );
    }
}
