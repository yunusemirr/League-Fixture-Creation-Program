<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::query()->create([
            "is_active" =>1,
            "name" => "Mahir Tekin",
            "surname" => "Erdensan",
            "email" => "humbldump@pm.me",
            "phone" => "05528842333",
            "tc" => "55900299672",
            "password" => bcrypt("123456")
        ]);
    }
}
