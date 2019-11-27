<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('titan::admin.users.index');
    }

    public function edit()
    {

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
