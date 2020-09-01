<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $faker = Faker::create();

        \DB::table('users')->insert(array(
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('hideworld1*'),
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
        ));
    }

}
