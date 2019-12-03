@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md">

                <div class="card shadow">
                    <div class="card-header">    
                        <h3 class="text-center">Roles</h3>
                    </div>

                    <div class="card-body">

                        <div class="row justify-content-end">
                            @can('crear roles')
                            <a class="btn btn-success mr-2" href="{{ route('roles.create') }}">Nuevo Rol</a>
                            @endcan
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
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td class="text-center">
                                                {{ $role->id }}
                                            </td>
                                            <td class="text-center">
                                                {{ $role->name }}
                                            </td>
                                            <td class="text-center">

                                                @can('ver roles')
                                                <a class="btn btn-secondary btn-sm" href="{{ route('roles.show', $role->id) }}">Ver</a>
                                                @endcan

                                                @can('editar roles')
                                                <a class="btn btn-secondary btn-sm" href="{{ route('roles.edit', $role->id) }}">Editar</a>
                                                @endcan

                                                @can('eliminar roles')

                                                {{ Form::open(['url' => route('roles.destroy', $role->id), 'method' => 'DELETE', 'onsubmit' => 'eliminar(event)', 'style' =>'display: inline;']) }}
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                {{ Form::close() }}
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

    <script>
        function eliminar(e){
            if(confirm('Seguro?')){
            }else{
                e.preventDefault();
                return false;
            }
        }
    </script>
@endsection