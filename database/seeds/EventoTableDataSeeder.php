<?php

use Illuminate\Database\Seeder;

class EventoTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventos = file_get_contents(database_path() . "/scripts/eventos.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $eventos)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
