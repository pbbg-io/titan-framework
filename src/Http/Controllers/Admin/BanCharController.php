<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use PbbgIo\Titan\Ban;
use PbbgIo\Titan\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Http\Requests\BannedCharRequest;
use PbbgIo\Titan\Support\BanUserService;

class BanCharController extends Controller
{

    private $banService;

    public function __construct(BanUserService $banService)
    {
        $this->banService = $banService;
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $playable = Character::all();
        return view('titan::admin.ban.char.create', compact('playable'));
    }

    /**
     * Store a newly created resource in storage.
     * @param BannedCharRequest $request
     * @return Response
     */
    public function store(BannedCharRequest $request)
    {
        $bannedChar = $this->banService->setUser(Character::findOrFail($request->bannable_id))
            ->setReason($request->reason)
            ->setBanUntil($request->ban_until)
            ->setForever($request->forever == 'on')
            ->placeBan();

        if($bannedChar)
        {
            flash()->success($bannedChar->bannable->name . ' has been banned');
            return redirect()->route('admin.banchar.edit', $bannedChar->id);
        }
        else
        {
            flash()->success('There was an error banning that character');
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
            ['reason' => $request->reason, 'ban_until' => ($request->ban_until != null ? new Carbon($request->ban_until) : null), 'forever' => $request->forever == 'on']
        );

        if($ban->exists())
        {

            flash()->success($char->display_name . ' has been banned');
            return redirect()->back();
        }
        else
        {
            flash()->success('There was an error banning that player');
            return redirect()->back();
        }
    }
}
