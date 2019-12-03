## Instalacion

Requisitos:

-Para Laravel 5.8.35

utilice 2 paquetes ( spatie/laravel-permission para los roles y laravelcollective/html para facilitar ciertas cosas en los formularios)

Instalan primero se intalan el paquete de roles:

``` bash
composer require spatie/laravel-permission
```

Agregamos el provider en el archivo `config/app.php`:

```php
'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
```

Ejecutamos lo siguiente en la consola

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
```

Despues de publicar las migraciones las ejecutamos corriendo en la consola:

```bash
php artisan migrate
```

Publicamos el archivo config:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
```

Cuando Publiquemos, [El Archivo de configuracion `config/permission.php`] Inmediatamente cargara el siguiente contenido:

```php
return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */
        'model_morph_key' => 'model_id',
    ],

    /*
     * When set to true, the required permission/role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * When checking for a permission against a model by passing a Permission
         * instance to the check, this key determines what attribute on the
         * Permissions model is used to cache against.
         *
         * Ideally, this should match your preferred way of checking permissions, eg:
         * `$user->can('view-posts')` would be 'name'.
         */

        'model_key' => 'name',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],
];
```

IMPORTATE!!! AGREGAR EL TRAIT `Spatie\Permission\Traits\HasRoles` al modelo `User` quedando asi:

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    // ...
}
```

Es importante tener en cuenta que el paquete nos trae 2 modelos `Permission` y `Role` que seran utilizados en nuestros controladores para manejar todo sobre ellos.


Ahora instalamos el paquete que nos ayudara en los formularios ('especificamente en su version 5.6 que funciona con larvel 5.8');

```bash
composer require "laravelcollective/html":"^5.8.0"
```

agregan el provider en `config/app.php`

```php
 'providers' => [
    // ...
    Collective\Html\HtmlServiceProvider::class,
    // ...
  ],
```

agregan 2 alias de clases. Igual en `config/app.php`

```php
'aliases' => [
    // ...
      'Form' => Collective\Html\FormFacade::class,
      'Html' => Collective\Html\HtmlFacade::class,
    // ...
  ],
```

ahora todo ready con los paquetes

## Fin Instalacion







## Implementacion

Ahora entramos en la parte importante. Donde estableceremos un estandar para la implementacion de roles y permisos:

Hacemos una lista de los permisos que necesitamos

Una vez definidos todos los permisos que utilizaremos en nuestra aplicacion procedemos a crear el Seeder necesario para cargar nuestra tabla de permisos

Creamos un Seeder

```bash
php artisan make:seeder RolesAndPermissionsSeeder
```

una vez creado el seeder en `database/seeds/RolesAndPermissionsSeeder.php` lo rellenan para cargar todos los permisos:
(aca les dejo el script para cargar los que me pasaron)

```php
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
        
        //Permisos Modulo Roles
        Permission::create(['name' => 'roles']);
        Permission::create(['name' => 'crear roles']);
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'editar roles']);
        Permission::create(['name' => 'eliminar roles']);

        /**
         * Permisos Precargardos
         */

        //Modulo Usuarios
        Permission::create(['name' => 'usuarios']);
        Permission::create(['name' => 'registrar usuarios']);
        Permission::create(['name' => 'consultar usuarios']);
        Permission::create(['name' => 'detalles de usuarios']);
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
        //Asignamos todos los permisos
        $role->givePermissionTo(Permission::all());


        //Roles Visitante , Administrador de roles (opcionales: este para demostrar el funcionamiento)
        $role2 = Role::create(['name' => 'Visitante']);
        $role2->givePermissionTo(['usuarios']);

        $role3 = Role::create(['name' => 'Administrador de roles']);
        $role3->givePermissionTo(['roles','ver roles', 'editar roles']);
    }
}

```


#### Para agregar, quitar o sincronizar permisos laravel-permission provee las siguentes funciones:


Para crear Roles y permisos
```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$role = Role::create(['name' => 'writer']);
$permission = Permission::create(['name' => 'edit articles']);
```

Para agregar permisos a un rol(cualquiera de las 2)
```php
$role->givePermissionTo($permission);
$permission->assignRole($role);
```

Para sincronizar permisos o roles( el mas utilizado puesto que sincroniza todos los permisos automaticamente)
```php
$role->syncPermissions($permissions); //Sincroniza permisos
$permission->syncRoles($roles); //Sincroniza roles
```

Para quitar roles o permisos especificos
```php
$role->revokePermissionTo($permission);
$permission->removeRole($role);
```

Las relaciones de los roles y permisos las provee el Trait `HasRoles` ejemplos:

```php
// get a list of all permissions directly assigned to the user
$permissionNames = $user->getPermissionNames(); // collection of name strings
$permissions = $user->permissions; // collection of permission objects

// get all permissions for the user, either directly, or from roles, or from both
$permissions = $user->getDirectPermissions();
$permissions = $user->getPermissionsViaRoles();
$permissions = $user->getAllPermissions();

// get the names of the user's roles
$roles = $user->getRoleNames(); // Returns a collection
```

y por ultimo para retornar los usuarios con ciertos roles o permisos
```php
$users = User::role('writer')->get(); // Returns only users with the role 'writer'
$users = User::permission('edit articles')->get(); // Returns only users with the permission 'edit articles' (inherited or directly)
```

## Fin Implementacion

## Directivas de Blade

Tenemos varias directivas en blade que podemos utilizar para proteccion en las vistas("OJO solo las vistas, se deben proteger la rutas aparte")

#### Directivas Blade para los permisos
```php
@can('edit articles')
  //
@endcan
```
o

```php
@if(auth()->user()->can('edit articles') && $some_other_condition)
  //
@endif
```

pueden usar `@can`, `@cannot`, `@canany`, y `@guest` para testear los permisos relacionados con el acceso.


### Roles 

#### Directivas para roles

Verificar un rol especifico:

```php
@role('writer')
    I am a writer!
@else
    I am not a writer...
@endrole
```
Tambien con:

```php
@hasrole('writer')
    I am a writer!
@else
    I am not a writer...
@endhasrole
```
chequea cualquier rol en la lista:
```php
@hasanyrole($collectionOfRoles)
    I have one or more of these roles!
@else
    I have none of these roles...
@endhasanyrole
 
// o

@hasanyrole('writer|admin')
    I am either a writer or an admin or both!
@else
    I have none of these roles...
@endhasanyrole
```
chequear todos los roles:

```php
@hasallroles($collectionOfRoles)
    I have all of these roles!
@else
    I do not have all of these roles...
@endhasallroles

// o

@hasallroles('writer|admin')
    I am both a writer and an admin!
@else
    I do not have all of these roles...
@endhasallroles
```

Arternativa contraria pera chequear que el usuario no tenga el rol:

```php
@unlessrole('does not have this role')
    I do not have the role
@else
    I do have the role
@endunlessrole
```



#### PROTECCION DE RUTAS

Aunque se impida al usuario ver las opciones en la vista con las directivas ateriores, si se deja tal cual se puede violar esa barrera ingresando mediante la url. Para evitar esto utilizamos los middleware que nos provee laravel-permission

para untilizar los middleware debemos agregarlos al archivo `app/Http/Kernel.php`.

```php
protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

Listo, pueden utilizar los middeware para proteger las rutas


Ejemplo para proteger las rutas por roles y/o permisos

```php
Route::group(['middleware' => ['role:super-admin']], function () {
    //
});

Route::group(['middleware' => ['permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role:super-admin','permission:publish articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:publish articles']], function () {
    //
});
```

se pueden separar multiples roles y permisos utilizando el caracter | (pipe) :

```php
Route::group(['middleware' => ['role:super-admin|writer']], function () {
    //
});

Route::group(['middleware' => ['permission:publish articles|edit articles']], function () {
    //
});

Route::group(['middleware' => ['role_or_permission:super-admin|edit articles']], function () {
    //
});
```
tambien se puede proteger los controladores utilizando el middleware en el contructor:

```php

public function __construct()
{
    $this->middleware(['role:super-admin','permission:publish articles|edit articles']);
}
public function __construct()
{
    $this->middleware(['role_or_permission:super-admin|edit articles']);
}
```

SOLO AGREGUE UN UserController y las rutas mas vistas. Sencillo. Espero les sea de utilidad.


Bueno, esto es todo. Dejo el codigo del modulo de roles y permisos para que lo vean y lo mejoren. Hay mas cosas sobre los paquetes que pueden revisar en su documentacion.



