<div class="form-group">
    <h3 class="text-center">Listado de Permisos</h3>
    <ul class=" list-unstyled">
        @foreach ($permissions as $permission)
            <li>
                <div class="custom-control custom-checkbox">
                    {{ Form::checkbox('permissions[]', $permission->id, $role->hasPermissionTo($permission->id), ['class' => 'custom-control-input', 'id' => 'customCheck'.$permission->id]) }}
                    <label class="custom-control-label" for="customCheck{{ $permission->id  }}">
                        <strong>{{ $permission->name }}</strong>
                    </label>                                    
                </div>                           
            </li>
        @endforeach
    </ul>
</div>