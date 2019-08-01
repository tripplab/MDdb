<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        //Users module
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'read users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'root-admin']);
        $role->givePermissionTo('create users');
        $role->givePermissionTo('read users');
        $role->givePermissionTo('update users');
        $role->givePermissionTo('delete users');
    }
}
