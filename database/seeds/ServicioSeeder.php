<?php

use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios = file_get_contents(database_path() . "/scripts/servicios.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $servicios)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
