<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index(){

        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    public function show(Role $role){
        $permissions = Permission::get();
        return view('roles.show', compact('role', 'permissions'));
    }

    public function create(){
    
        $role = new Role();
        $permissions = Permission::get();
    
        return view('roles.create', compact('permissions', 'role'));
    }

    public function store(Request $request, Role $role){

        Validator::make($request->all(),[
            'name' => 'string|required'
        ])->validate();

        $role->create($request->only('name'));
        $role->syncPermissions($request->get('permissions'));

        return redirect()->route('roles');
    }

    public function edit(Role $role){
    
        $permissions = Permission::get();
    
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role){

        Validator::make($request->all(),[
            'name' => 'required|string'
        ])->validate();

        $role->update($request->only('name'));
        $role->syncPermissions($request->get('permissions'));

        return redirect()->route('roles.edit', $role->id)
            ->with('alerta', 'Rol Actualizado Correctamente!');
    }

    public function destroy($id){
        Role::destroy($id);

        return redirect()->route('roles');
    }

}
