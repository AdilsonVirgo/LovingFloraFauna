<?php

use Illuminate\Database\Seeder;

class CocodrileraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cocodrileras = file_get_contents(database_path() . "/scripts/cocodrileras.sql");
        $statements = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $cocodrileras)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
    }
}
