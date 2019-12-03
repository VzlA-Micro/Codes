@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h3 class="text-center">Usuario</h3>
        </div>

        <div class="card-body">



            <div class="form-row">
                <label for=""><strong>Nombre</strong></label>
                <input class="form-control-plaintext" disabled value="{{ $user->name }}" type="text" name="name" id="" placeholder="Ej. editar usuarios" required>
            </div>

            <div class="form-row">
                <label for=""><strong>Email</strong></label>
                <input class="form-control-plaintext" disabled value="{{ $user->email }}" type="text" name="name" id="" placeholder="Ej. editar usuarios" required>
            </div>
            

            <div class="form-row justify-content-center">
                <a class="btn btn-secondary" href="javascript:history.go(-1)">Atras</a>
            </div>

      

        </div>

    </div>

</div>

@endsection