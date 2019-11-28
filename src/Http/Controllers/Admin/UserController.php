<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateUserRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends Controller
{
    public function index(): View
    {
        return view('titan::admin.users.index');
    }

    public function edit(User $user)
    {

        return view('titan::admin.users.edit', compact('user'));
    }

    public function create(): View
    {
        return view('titan::admin.users.create');
    }

    public function store(CreateUpdateUserRequest $request): RedirectResponse
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->password = bcrypt('password');

        $user->save();

        flash('User "' . $user->name . '" has been created')->success();

        return redirect()->route('admin.users.edit', $user);
    }

    public function update(CreateUpdateUserRequest $request, User $user): RedirectResponse {
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->has('password') && $request->input('password') !== null)
            $user->password = bcrypt('password');

        $user->save();

        flash('User "' . $user->name . '" has been updated')->success();

        return redirect()->route('admin.users.edit', $user);
    }

    public function show(): View
    {
        return view('titan::admin.users.show');
    }

    public function delete(): View {

    }

    public function destroy(): View {

    }

    public function datatable()
    {
        return datatables(User::select(["id", "name", "email", "email_verified_at", "last_move", "created_at"]))
            ->addColumn('action', function ($user) {
                $route = route('admin.users.edit', $user);
                return '<a href="' . $route . '" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
            })
            ->editColumn('email_verified_at', function ($user) {
                if (!$user->email_verified_at) {
                    return 'Not Verified';
                }

                return (new Carbon($user->email_verified_at));
            })
            ->editColumn('last_move', function ($user) {
                if (!$user->last_move) {
                    return 'Never';
                }

                return (new Carbon($user->last_move))->diffForHumans();
            })->toJson();
    }
}
