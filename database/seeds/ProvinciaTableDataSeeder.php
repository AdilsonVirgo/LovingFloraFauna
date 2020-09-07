<?php

use Illuminate\Database\Seeder;

class ProvinciaTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provincias = file_get_contents(database_path() . "/scripts/provincias.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $provincias)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
