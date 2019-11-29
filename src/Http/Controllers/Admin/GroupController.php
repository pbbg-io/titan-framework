<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Http\Requests\GroupRequest;
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
        return view('titan::admin.groups.create');
    }

    public function store(GroupRequest $request): RedirectResponse
    {
        $role = new Role();
        $role->fill($request->all());
        $role->save();

        return redirect()->route('admin.groups.index');
    }

    public function edit(Role $group) {
        return view('titan::admin.groups.edit', compact('group'));
    }

    public function update(GroupRequest $request, Role $group): RedirectResponse {
        $group->fill($request->all());
        $group->save();

        flash("{$group->name} has been updated")->success();

        return redirect()->route('admin.groups.edit', compact('group'));
    }

    public function destroy(Role $role) {
        $role->delete();

        flash('Role deleted');

        return redirect()->route('admin.groups.index');
    }
}
