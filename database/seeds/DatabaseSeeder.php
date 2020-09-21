<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        //
        $this->call(UserSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ProvinciaSeeder::class);
        $this->call(ServicioSeeder::class);
        $this->call(MercadoTableDataSeeder::class);
        $this->call(AgenciaTableDataSeeder::class);
        $this->call(EcuestreTableDataSeeder::class);
        $this->call(EventoTableDataSeeder::class);
        $this->call(ExcursionTableDataSeeder::class);
        $this->call(GastronomiaTableDataSeeder::class);
        $this->call(NacTableDataSeeder::class);
        $this->call(UebsTableDataSeeder::class);
    }

}
