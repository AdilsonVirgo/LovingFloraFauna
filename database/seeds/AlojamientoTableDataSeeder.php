<?php

use Illuminate\Database\Seeder;

class AlojamientoTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alojamientos = file_get_contents(database_path() . "/scripts/alojamientos.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $alojamientos)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
