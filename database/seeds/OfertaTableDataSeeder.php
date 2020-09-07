<?php

use Illuminate\Database\Seeder;

class OfertaTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ofertas = file_get_contents(database_path() . "/scripts/ofertas.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $ofertas)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
