<?php

use Illuminate\Database\Seeder;

class EcuestreTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ecuestres = file_get_contents(database_path() . "/scripts/ecuestres.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $ecuestres)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
