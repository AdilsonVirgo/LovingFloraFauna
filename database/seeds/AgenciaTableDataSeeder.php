<?php

use Illuminate\Database\Seeder;

class AgenciaTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agencias = file_get_contents(database_path() . "/scripts/agencias.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $agencias)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
