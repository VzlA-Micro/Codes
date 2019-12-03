<?php

use App\Producto;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create(['nombre' => 'Libreta']);
        Producto::create(['nombre' => 'Lapiz']);
        Producto::create(['nombre' => 'Marcador']);
        Producto::create(['nombre' => 'Borra']);
        Producto::create(['nombre' => 'Lapicero']);
        Producto::create(['nombre' => 'Libro']);

    }
}
