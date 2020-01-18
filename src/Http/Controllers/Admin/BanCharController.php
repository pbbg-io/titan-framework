<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use PbbgIo\Titan\Ban;
use PbbgIo\Titan\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Http\Requests\BannedCharRequest;


class BanCharController extends Controller
{
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $chars = Character::all();
        return view('titan::admin.ban.char.create', compact('chars'));
    }

    /**
     * Store a newly created resource in storage.
     * @param BannedCharRequest $request
     * @return Response
     */
    public function store(BannedCharRequest $request)
    {
        $char = Character::findOrFail($request->bannable_id);

        if($char->placeBan($request->reason, $request->ban_until, $request->forever == 'on'))
        {
            flash()->success($char->display_name . ' has been banned');
            return redirect()->back()->withInput();
        }
        else
        {
            flash()->success('There was an error banning that player');
            return redirect()->back()->withInput();
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
        return view('titan::admin.ban.char.edit', compact('banned'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(BannedCharRequest $request, $id)
    {
        $char = Character::findOrFail($request->bannable_id);
        $ban = Ban::updateOrCreate(
            ['bannable_id' => $request->bannable_id, 'bannable_type' => get_class($char)],
            ['reason' => $request->reason, 'ban_until' => ($request->ban_until != null ? \Carbon\Carbon::parse($request->ban_until)->toDateString() : null), 'forever' => $request->forever == 'on']
        );

        if($ban->exists())
        {

            flash()->success($char->display_name . ' has been banned');
            return redirect()->back()->withInput();
        }
        else
        {
            flash()->success('There was an error banning that player');
            return redirect()->back()->withInput();
        }
    }
}
