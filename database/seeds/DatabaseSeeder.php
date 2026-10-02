<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "اطلس",
            'family' => "وب",
            'email' => "ciwcertificate@gmail.com",
            'role_id' => 1,
            'password' => bcrypt('123456'),
        ]);

        DB::table('roles')->insert([
            'name' => "ادمین اطلس",
            'slug' => "atlas-administrator",
        ]);

        DB::table('roles')->insert([
            'name' => "ادمین",
            'slug' => "administrator",
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
        ]);
    }
}
