<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\Titan\Area;
use PbbgIo\Titan\Character;
use PbbgIo\Titan\Http\Requests\CreateUpdateAreaRequest;
use PbbgIo\Titan\Stat;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('titan::admin.areas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('titan::admin.areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateAreaRequest $request)
    {
        $area = new Area();
        $area->fill($request->only('name'));
        $area->save();

        flash("Area created");

        return redirect()->route('admin.areas.edit', $area);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        return view('titan::admin.areas.edit', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('titan::admin.areas.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateAreaRequest $request, Area $area)
    {
        $area->name = $request->input('name');
        $area->save();
        flash("Area Updated")->success();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $firstLocation = Area::first();

        if ($firstLocation->id === $area->id) {
            abort(411, "You must have at least one area");
        }

        Character::where('area_id', $area->id)
            ->update([
                'area_id' => $firstLocation->id
            ]);

        $area->delete();

        flash("Area deleted")->success();

        return response()->json(['ok']);
    }

    public function datatable(): JsonResponse
    {
        return datatables(Area::select())
            ->addColumn('action', function ($area) {
                $routeEdit = route('admin.areas.edit', $area);
                $routeDelete = route('admin.areas.destroy', $area);
                $buttons = '';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
                $buttons .= '<a href="' . $routeDelete . '" class="btn btn-xs btn-danger delete"><i class="fas fa-times-circle fa-sm text-white-50"></i> Delete</a>';
                return $buttons;
            })->toJson();
    }
}
