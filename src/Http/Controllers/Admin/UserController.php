<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Character;
use PbbgIo\Titan\Http\Requests\CreateUpdateUserRequest;
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

    public function list()
    {
        $list = User::select(['id', 'name', 'name as text'])
            ->where('name', 'LIKE', '%' . request()->input('q') . '%')
            ->orWhere('email', 'LIKE', '%' . request()->input('q') . '%')
            ->orWhere('id', 'LIKE', '%' . request()->input('q') . '%')
            ->get();

        return response()->json([
            'results' => $list,
        ]);
    }

    public function store(CreateUpdateUserRequest $request): RedirectResponse
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->password = bcrypt('password');

        $user->save();

        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }


        flash('User "' . $user->name . '" has been created')->success();

        return redirect()->route('admin.users.edit', $user);
    }

    public function update(CreateUpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->has('password') && $request->input('password') !== null) {
            $user->password = bcrypt('password');
        }

        $user->save();

        if ($request->has('roles')) {
            $user->syncRoles($request->input('roles'));
        }

        flash('User "' . $user->name . '" has been updated')->success();

        return redirect()->route('admin.users.edit', $user);
    }

    public function show(): View
    {
        return view('titan::admin.users.show');
    }

    public function delete(): View
    {

    }

    public function destroy(User $user)
    {
        if ($user->id !== \Auth::user()->id) {
            $user->characters
                ->each(function ($char) {
                    $char->stats->each(function ($stat) {
                        $stat->delete();
                    });

                    $char->delete();
                });
            $user->delete();
        } else {
            abort(411, "Invalid user");
        }
    }

    public function datatable(): JsonResponse
    {
        return datatables(User::select(["id", "name", "email", "email_verified_at", "last_move", "created_at"]))
            ->addColumn('action', function ($user) {
                $routeEdit = route('admin.users.edit', $user);
                $routeDelete = route('admin.users.destroy', $user);
                $buttons = '';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
                $buttons .= '<a href="' . $routeDelete . '" class="btn btn-xs btn-danger delete"><i class="fas fa-times-circle fa-sm text-white-50"></i> Delete</a>';
                return $buttons;
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
