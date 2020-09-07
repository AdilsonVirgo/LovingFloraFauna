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
        \DB::table('users')->insert([
            'name' => 'adilson',
            'email' => 'adilsonvirgo@gmail.com',
            'password' => bcrypt('secret'),
        ]);
        \DB::table('users')->insert([
            'name' => 'yuneisi',
            'email' => 'tur.esp1@ua.ffauna.co.cu',
            'password' => bcrypt('secret'),
        ]);
        \DB::table('users')->insert([
            'name' => 'grey',
            'email' => 'dir.tur@ua.ffauna.co.cu',
            'password' => bcrypt('secret'),
        ]);
        \DB::table('users')->insert([
            'name' => 'jordan',
            'email' => 'tur.esp3@ua.ffauna.co.cu',
            'password' => bcrypt('secret'),
        ]);
        \DB::table('users')->insert([
            'name' => 'gleidis',
            'email' => 'tur.esp5@ua.ffauna.co.cu',
            'password' => bcrypt('secret'),
        ]);
    }

}
