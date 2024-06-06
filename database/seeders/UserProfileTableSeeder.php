<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserProfileTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        UserProfile::insert([
            [
                'id' => 1,
                'user_id' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
