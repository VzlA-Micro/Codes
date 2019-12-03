@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md">

                <div class="card shadow">
                    <div class="card-header">    
                        <h3 class="text-center">Usuarios</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nro</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                {{ $user->id }}
                                            </td>
                                            <td class="text-center">
                                                {{ $user->name }}
                                            </td>
                                            <td class="text-center">
                                                    {{ $user->email }}
                                                </td>
                                            <td class="text-center">
                                                <a class="btn btn-secondary btn-sm" href="{{ route('users.show', $user->id) }}">Ver</a>
                                                <a class="btn btn-secondary btn-sm" href="{{ route('users.edit', $user->id) }}">Editar</a>
                                                <a class="btn btn-danger btn-sm" href="#">Eliminar</a>
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