<?php

use Illuminate\Database\Seeder;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $user = new \App\Models\User;
            $user->name = $faker->name;
            $user->email = $faker->unique()->safeEmail;
            $user->password = bcrypt('secret');
            $user->flag_delete = 0;
            $user->remember_token = str_random(10);
            $user->save();
        }
    }
}
