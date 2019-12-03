@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">Nuevo Rol</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class=" form-group">
                    <label for="">Alias del Rol</label>
                    <input class="form-control" type="text" name="name" value="{{ $role->name }}" id="" placeholder="Ej. Administrador" required>
                </div>

                <hr>

                @include('roles.parcials._permissions')             

                <div class="form-row justify-content-center">
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection