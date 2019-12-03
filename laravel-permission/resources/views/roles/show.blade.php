@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">Rol</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class=" form-group">
                    <label for=""><strong>Alias del Rol</strong></label>
                    <input class="form-control-plaintext" disabled type="text" name="name" value="{{ $role->name }}" id="" placeholder="Ej. Administrador" required>
                </div>

                <hr>

                <div class="form-group">
                    <ul class=" list-unstyled">
                        @foreach ($permissions as $permission)
                            <li>
                                <div class="custom-control custom-checkbox">
                                    {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->id), ['class' => 'custom-control-input', 'id' => 'customCheck'.$permission->id, 'disabled']) }}
                                    <label class="custom-control-label" for="customCheck{{ $permission->id  }}">
                                        <strong>{{ $permission->name }}</strong>
                                    </label>                                    
                                </div>                           
                            </li>
                        @endforeach
                    </ul>
                </div>            

                <div class="form-row justify-content-center">
                    <a class="btn btn-secondary" href="javascript:history.go(-1)">Atras</a>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection