<?php

use Illuminate\Database\Seeder;

class UebsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $uebs = file_get_contents(database_path() . "/scripts/uebs.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $uebs)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
