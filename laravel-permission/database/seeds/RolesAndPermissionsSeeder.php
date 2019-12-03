<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        //Restablecer roles y permisos en caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permisos para prueba (quitar esto por favor al igual que el modelo, migracion y vista de productos)
        Permission::create(['name' => 'productos']);
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'eliminar productos']);

        //Permisos Modulo Roles
        Permission::create(['name' => 'roles']);
        Permission::create(['name' => 'crear roles']);
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'editar roles']);
        Permission::create(['name' => 'eliminar roles']);

        /**
         * Permisos
         */

        //Modulo Usuarios
        Permission::create(['name' => 'usuarios']);
        Permission::create(['name' => 'detalles de usuarios']);
        Permission::create(['name' => 'registrar usuarios']);
        Permission::create(['name' => 'modificar usuarios']);
        Permission::create(['name' => 'habilitar y deshabilitar usuarios']);
        Permission::create(['name' => 'resetear usuarios']);

        //Modulo Contribuyentes
        Permission::create(['name' => 'contribuyentes']);
        Permission::create(['name' => 'registrar contribuyentes']);
        Permission::create(['name' => 'consultar contribuyentes']);
        Permission::create(['name' => 'detalles de contribuyentes']);
        Permission::create(['name' => 'habilitar y deshabilitar contribuyentes']);
        Permission::create(['name' => 'resetear contribuyentes']);

        //Modulo Empresas
        Permission::create(['name' => 'empresas']);
        Permission::create(['name' => 'registrar empresas']);
        Permission::create(['name' => 'consultar empresas']);
        Permission::create(['name' => 'detalles de empresas']);
        Permission::create(['name' => 'historial pago de empresas']);
        Permission::create(['name' => 'añadir ciiu empresas']);
        Permission::create(['name' => 'habilitar y deshabilitar ciiu empresas']);

        Permission::create(['name' => 'geosemat']);
        Permission::create(['name' => 'ver estadisticas']);

        //Modulo de Pagos
        Permission::create(['name' => 'pagos']);
        Permission::create(['name' => 'validar pagos']);
        Permission::create(['name' => 'verificar y cancelar pagos']);
        Permission::create(['name' => 'ver pagos web']);
        Permission::create(['name' => 'ver pagos por transferencia']);
        Permission::create(['name' => 'ver pagos por punto de ventas']);

        Permission::create(['name' => 'generar planilla']);
        Permission::create(['name' => 'pagar planilla']);

        Permission::create(['name' => 'seguridad']);

        //Creamos el Rol del superUsuario
        $role = Role::create(['name' => 'Super Usuario']);
        $role->givePermissionTo(Permission::all());

        //Visitante
        $role2 = Role::create(['name' => 'Visitante']);
        $role2->givePermissionTo(['roles', 'productos', 'usuarios']);

        //Administrador de roles
        $role3 = Role::create(['name' => 'Administrador de roles']);
        $role3->givePermissionTo(['roles','crear roles','ver roles', 'editar roles']);
    }
}
