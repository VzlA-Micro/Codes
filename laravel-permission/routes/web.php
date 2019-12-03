<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//quitar esto 
use App\Producto;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group( function () {

    Route::get('/home', 'HomeController@index')->name('home');

    /**
     * Laravel-Permissions (Proteccion por Niveles)
     */
    
    /**
     * USUARIOS
     */
    //NIVEL 1 (Ingersar al modulo)
    Route::group(['middleware' => ['permission:usuarios']], function () {
        
        Route::get('/users', 'UserController@index')->name('users');

        //NIVEL 2 (ver usuarios)
        Route::group(['middleware' => ['permission:detalles de usuarios']], function () {

            Route::resource('users', 'UserController')->only('show');
        
            //NIVEL 3 (modificar usuarios | habilitar y deshabilitar usuarios)
            Route::group(['middleware' => ['permission:modificar usuarios|habilitar y deshabilitar usuarios']], function () {

                Route::resource('users', 'UserController')->only('edit', 'update');
                
                //NIVEL 4 (Eliminar usuarios)
                Route::group(['middleware' => ['permission:eliminar usuarios']], function () {

                    Route::resource('users', 'UserController')->only('destroy');
                    
                });

            });

        });
        
    });

    /**
     * ROLES   
     */
    //NIVEL 1 (Ingersar al modulo)
    Route::group(['middleware' => ['permission:roles']], function () {
        
        Route::get('/roles', 'Permissions\RoleController@index')->name('roles');
        
        //NIVEL 2 (ver roles)
        Route::group(['middleware' => ['permission:ver roles']], function () {

            Route::resource('roles', 'Permissions\RoleController')->only('show');
        
            //NIVEL 3 (modificar roles)
            Route::group(['middleware' => ['permission:editar roles|crear roles']], function () {

                Route::resource('roles', 'Permissions\RoleController')->only('create', 'store', 'edit', 'update');
                
                //NIVEL 4 (Eliminar roles)
                Route::group(['middleware' => ['permission:eliminar roles']], function () {

                    Route::resource('roles', 'Permissions\RoleController')->only('destroy');

                });

            });

        });
        
    });

    


    Route::group(['middleware' => ['permission:ver productos']], function () {

        Route::get('/productos', function () {
    
            $productos = Producto::all();
    
            return view('productos', ['productos' => $productos]);
        })->name('productos');
        
    });


});


Auth::routes();


