<?php

use Illuminate\Database\Seeder;

class SenderoTableDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $senderos = file_get_contents(database_path() . "/scripts/senderos.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $senderos)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }//
    }

}
