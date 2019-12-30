<h3 class="mb-4 text-gray-800">Permissions this group has</h3>
@foreach($permissions as $permission)
    <li class="list-group-item toggle-switch">
        Manage {{ $permission->name }}
        <label class="switch ">
            <input type="checkbox" class="success" value="1" name="permissions[{{ $permission->id }}]"
                   @if((isset($group) && $group->hasPermissionTo($permission->name)) || old('permissions.' . $permission->id)) checked @endif
            >
            <span class="slider round"></span>
        </label>
    </li>
@endforeach
@dump(old())
