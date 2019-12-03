@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">Editar Rol</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class=" form-group">
                    <label for=""><strong>Alias del Rol</strong></label>
                    <input class="form-control" type="text" value="{{ $role->name }}" name="name" id="" placeholder="Ej. Administrador" required>
                </div>
                <hr>

                @include('roles.parcials._permissions')             

                <div class="form-row justify-content-center">
                    <a class="btn btn-secondary mr-2" href="javascript:history.go(-1)">Atras</a>
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection