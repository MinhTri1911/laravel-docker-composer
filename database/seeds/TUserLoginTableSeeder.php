<?php

use Illuminate\Database\Seeder;

class TUserLoginTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i < 10; $i++) {
            $user = new \App\Models\TUserLogin;
            $user->name = $faker->unique()->name;
            $user->ope_company_id = 1;
            $user->department = str_random(20);
            $user->position = str_random(50);
            $user->login_id = 'admin' . $i;
            $user->password = bcrypt('123456');
            $user->del_flag = 0;
            $user->created_by = 1;
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
        }
    }
}
