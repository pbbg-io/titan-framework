<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\TitanFramework\Area;
use PbbgIo\TitanFramework\Character;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateCharacterRequest;
use PbbgIo\TitanFramework\Stat;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('titan::admin.characters.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $areas = Area::all();
        $stats = Stat::all();

        return view('titan::admin.characters.create', compact('areas', 'stats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateCharacterRequest $request): RedirectResponse
    {
        $character = new Character();

        $character->fill($request->only('display_name', 'area_id'));
        $character->user_id = $request->input('user_id');
        $character->last_move = new Carbon();
        $character->save();

        $character->seedStats();

        $stats = $request->input('stats');

        $character->stats->each(function($stat) use($stats) {
            if($stat->type->type === Stat::TYPE_BOOLEAN)
            {
                if(isset($stats[$stat->stat_id]))
                    $value = 1;
                else
                    $value = 0;
            }

            if(!isset($value))
                $value = $stats[$stat->stat_id];

            $stat->value = $value;
            $stat->save();
        });

        flash("Character has been created")->success();

        return redirect()->route('admin.characters.edit', $character);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {

        return view('titan::admin.characters.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character): View
    {
        $areas = Area::all();
        $stats = Stat::all();
        return view('titan::admin.characters.edit', compact('character', 'areas', 'stats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateCharacterRequest $request, Character $character): RedirectResponse
    {
        $character->fill($request->only('display_name', 'area_id'));
        $character->save();

        $stats = $request->input('stats');

        $character->stats->each(function($stat) use($stats) {
            if($stat->type->type === Stat::TYPE_BOOLEAN)
            {
                if(isset($stats[$stat->stat_id]))
                    $value = 1;
                else
                    $value = 0;
            }

            if(!isset($value))
                $value = $stats[$stat->stat_id];

            $stat->value = $value;
            $stat->save();
        });

        flash("Character has been updated")->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatable(): JsonResponse
    {
        return datatables(Character::select())
            ->addColumn('action', function ($character) {
                $route = route('admin.characters.edit', $character);
                return '<a href="' . $route . '" class="btn btn-xs btn-primary"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
            })
            ->editColumn('last_move', function ($character) {
                if (!$character->last_move) {
                    return 'Never';
                }

                return (new Carbon($character->last_move))->diffForHumans();
            })->toJson();
    }
}
