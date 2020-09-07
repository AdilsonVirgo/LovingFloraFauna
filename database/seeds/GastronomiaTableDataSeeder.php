<?php

use Illuminate\Database\Seeder;

class GastronomiaTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $gastronomias = file_get_contents(database_path() . "/scripts/gastronomias.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $gastronomias)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
