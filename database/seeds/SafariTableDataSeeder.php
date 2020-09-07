<?php

use Illuminate\Database\Seeder;

class SafariTableDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $safaris = file_get_contents(database_path() . "/scripts/safaris.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $safaris)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }

}
