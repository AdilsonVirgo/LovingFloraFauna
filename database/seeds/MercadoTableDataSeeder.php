<?php

use Illuminate\Database\Seeder;

class MercadoTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $mercados = file_get_contents(database_path() . "/scripts/mercados.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $mercados)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
