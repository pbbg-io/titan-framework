<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\Titan\Character;
use PbbgIo\Titan\CharacterStat;
use PbbgIo\Titan\Http\Requests\CreateUpdateStatRequest;
use PbbgIo\Titan\Stat;

class StatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('titan::admin.stats.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $types = Stat::AVAILABLE_TYPES;
        return view('titan::admin.stats.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateStatRequest $request)
    {
        $stat = new Stat();
        $stat->fill($request->all());
        $stat->save();

        flash("Stat has been saved")->success();

        return redirect()->route('admin.stats.edit', $stat);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Stat $stat): View
    {
        $types = Stat::AVAILABLE_TYPES;

        return view('titan::admin.stats.show', compact('stat', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Stat $stat): View
    {
        $types = Stat::AVAILABLE_TYPES;
        return view('titan::admin.stats.edit', compact('stat', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateStatRequest $request
     * @param Stat $stat
     * @return RedirectResponse
     */
    public function update(CreateUpdateStatRequest $request, Stat $stat): RedirectResponse
    {
        $stat->update($request->all());
        $stat->save();

        flash("Stat has been updated")->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stat $stat)
    {
        CharacterStat::whereStatId($stat->id)->delete();
        $stat->delete();
        flash("Stat has been deleted")->success();

        return response()->json(['ok']);
    }

    public function datatable(): JsonResponse
    {
        return datatables(Stat::select())
            ->addColumn('action', function ($stat) {
                $routeEdit = route('admin.stats.edit', $stat);
                $routeDelete = route('admin.stats.destroy', $stat);
                $buttons = '';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
                $buttons .= '<a href="' . $routeDelete . '" class="btn btn-xs btn-danger delete"><i class="fas fa-times-circle fa-sm text-white-50"></i> Delete</a>';
                return $buttons;
            })->toJson();
    }
}
