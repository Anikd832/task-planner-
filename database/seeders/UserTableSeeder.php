<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::insert([
            [
                'id' => 1,
                'full_name' => 'Super Admin',
                'roles' => 'super_admin',
                'email' => 'admin@educitybd.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'remember_token' => Str::random(10),
                'created_at' => now(),
            ],
        ]);
    }
}
