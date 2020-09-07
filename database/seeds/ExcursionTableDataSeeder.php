<?php

use Illuminate\Database\Seeder;

class ExcursionTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $excursions = file_get_contents(database_path() . "/scripts/excursions.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $excursions)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
