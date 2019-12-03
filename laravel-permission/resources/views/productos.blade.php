@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md">

                <div class="card shadow">
                    <div class="card-header">    
                        <h3 class="text-center">Productos</h3>
                    </div>

                    <div class="card-body">

                        <div class="row justify-content-end">
                            <a class="btn btn-success mr-2" href="{{ route('roles.create') }}">Nuevo Producto</a>
                        </div>

                        <div class="row">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nro</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td class="text-center">
                                                {{ $producto->id }}
                                            </td>
                                            <td class="text-center">
                                                {{ $producto->nombre }}
                                            </td>
                                            <td class="text-center">
                                                @can('ver productos')
                                                <a class="btn btn-secondary btn-sm" href="#">Ver</a>
                                                @endcan

                                                @can('editar productos')
                                                <a class="btn btn-secondary btn-sm" href="#">Editar</a>    
                                                @endcan

                                                @can('eliminar productos')
                                                <a class="btn btn-danger btn-sm" href="#">Eliminar</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection