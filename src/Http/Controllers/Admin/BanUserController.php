<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use App\User;
use PbbgIo\Titan\Ban;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Http\Requests\BannedUserRequest;

class BanUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $playable = User::all();
        return view('titan::admin.ban.user.create', compact('playable'));
    }

    /**
     * Store a newly created resource in storage.
     * @param BannedUserRequest $request
     * @return Response
     */
    public function store(BannedUserRequest $request)
    {
        $user = User::findOrFail($request->bannable_id);

        if($user->placeBan($request->reason, $request->ban_until, $request->forever == 'on'))
        {
            flash()->success($user->name . ' has been banned');
            return redirect()->route('admin.banuser.edit');
        }
        else
        {
            flash()->error('There was an error banning that player');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $banned = Ban::with('bannable')->findOrFail($id);
        return view('titan::admin.ban.user.edit', compact('banned'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BannedUserRequest $request, $id)
    {
        $user = User::findOrFail($request->bannable_id);
        $ban = Ban::updateOrCreate(
            ['bannable_id' => $request->bannable_id, 'bannable_type' => get_class($user)],
            ['reason' => $request->reason, 'ban_until' => ($request->ban_until != null ? new Carbon($request->ban_until) : null), 'forever' => $request->forever == 'on']
        );

        if($ban->exists())
        {

            flash()->success($user->name . ' has been banned');
            return redirect()->back();
        }
        else
        {
            flash()->error('There was an error banning that player');
            return redirect()->back();
        }
    }
}
