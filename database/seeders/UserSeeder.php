<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => $faker->email(),
            'phone' => $faker->phoneNumber,
            'post_code' => 510003,
            'city' => $faker->city(),
            'ward' => $faker->streetName(),
            'address' => $faker->address(),
            'role' => User::ADMIN,
            'note' => $faker->text(30),
            'password' => bcrypt('password'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        for($i = 0; $i < 10; $i++){
            DB::table('users')->insert([
                'name' => $faker->userName(),
                'email' => $faker->email(),
                'phone' => $faker->phoneNumber,
                'post_code' => 510003,
                'city' => $faker->city(),
                'ward' => $faker->streetName(),
                'address' => $faker->address(),
                'role' => User::USER,
                'note' => $faker->text(30),
                'password' => bcrypt('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
