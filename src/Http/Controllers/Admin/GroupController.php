<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Http\Requests\GroupRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{
    public function index(): View
    {
        $groups = Role::where('name', '!=', 'Super Admin')->get();
        return view('titan::admin.groups.index', compact('groups'));
    }

    public function create(): View
    {
        $permissions = Permission::all();
        return view('titan::admin.groups.create', compact('permissions'));
    }

    public function store(GroupRequest $request): RedirectResponse
    {
        $role = new Role();
        $role->fill($request->only('name', 'prefix', 'suffix'));
        $role->save();

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('admin.groups.edit', $role);
    }

    public function edit(Role $group) {
        $permissions = Permission::all();
        return view('titan::admin.groups.edit', compact('group', 'permissions'));
    }

    public function update(GroupRequest $request, Role $group): RedirectResponse {
        $group->fill($request->only('name', 'prefix', 'suffix'));
        $group->save();

        $groups = collect($request->input('permissions'));
        $group->syncPermissions($groups->keys());

        flash("{$group->name} has been updated")->success();

        return redirect()->route('admin.groups.edit', compact('group'));
    }

    public function destroy(Role $role) {
        $role->delete();

        flash('Role deleted');

        return redirect()->route('admin.groups.index');
    }
}
