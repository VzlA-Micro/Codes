<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(){

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function edit(User $user){
        $roles = Role::get();
        return view('users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user){

        Validator::make($request->all(), [
            'name' => 'string|required'
        ])->validate();

        $user->update($request->all());

        $user->syncRoles($request->get('roles'));

        // return response($request->get('roles'));

        return redirect()->route('users.edit', $user->id)
            ->with('alerta', 'Usuario Actualizado correctamente!');
    }
}
