<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Admin = Role::create(['name' => 'admin']);

        $Operadora = Role::create(['name' => 'operadora']);

        // Permisos de Usuarios.

        Permission::create([
            'name' => 'dashboard.users.index', 'description' => 'Ver el panel de Usuarios'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.create', 'description' => 'Crear el usuario'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.store', 'description' => 'Guardar el Usuario'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.show', 'description' => 'Mostrar el usuario'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.edit', 'description' => 'Editar el usuario'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.update', 'description' => 'Actualizar el usuario'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.users.destroy', 'description' => 'Eliminar el usuario'
        ])->syncRoles([$Admin]);

        //Persmisos de Roles

        Permission::create([
            'name' => 'dashboard.roles.index', 'description' => 'Ver la lista de Permisos'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.create', 'description' => 'Crear un Permiso'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.store', 'description' => 'Almacenar un Rol en la BD'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.show', 'description' => 'Mostrar la informacion de un Rol'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.edit', 'description' => 'Editar la informacion de un Rol'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.update', 'description' => 'Actualizar la informacion de un Rol en la BD'
        ])->syncRoles([$Admin]);
        Permission::create([
            'name' => 'dashboard.roles.destroy', 'description' => 'Eliminar un Rol de la BD'
        ])->syncRoles([$Admin]);
    }
}
