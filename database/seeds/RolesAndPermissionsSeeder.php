<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'homeAlert']);
        Permission::create(['name' => 'homeSide']);
        Permission::create(['name' => 'homeMain']);
        Permission::create(['name' => 'homeFooter']);

        // create roles and assign created permissions
        $user = User::where('name', 'admin')->first();
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo(Permission::all());
        $user->assignRole($role);

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo([
            'homeAlert',
            'homeSide',
            'homeFooter',
        ]);
    }

}
