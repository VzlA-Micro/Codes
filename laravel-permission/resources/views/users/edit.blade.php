@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">Usuario</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class=" form-group">
                    <label for=""><strong>Nombre</strong></label>
                    <input class="form-control" type="text" name="name" id="" value="{{ $user->name }}" placeholder="Ej. editar usuarios" required>
                </div>
                <hr>
                <h3 class="text-center">Lista de Roles</h3>
                <div class="form-group">
                    <ul class=" list-unstyled">
                        @foreach ($roles as $role)
                            <li>
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('roles[]', $role->id, $user->hasRole($role->id), ['class' => 'custom-control-input', 'id' => 'customCheck'.$role->id]) }}
                                    <label class="custom-control-label" for="customCheck{{ $role->id    }}">
                                        <strong>{{ $role->name }}</strong>
                                        <em>{{ $role->description }}</em>
                                    </label>                                    
                                </div>                           
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="form-row justify-content-center">
                    <a class="btn btn-secondary mr-2" href="javascript:history.go(-1)">Atras</a>
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection