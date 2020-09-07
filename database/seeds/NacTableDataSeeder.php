<?php

use Illuminate\Database\Seeder;

class NacTableDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $nacs = file_get_contents(database_path() . "/scripts/nacs.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $nacs)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }

}
