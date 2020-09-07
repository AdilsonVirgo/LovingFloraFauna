<?php

use Illuminate\Database\Seeder;

class NauticaTableDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $nauticas = file_get_contents(database_path() . "/scripts/nauticas.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $nauticas)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }

}
