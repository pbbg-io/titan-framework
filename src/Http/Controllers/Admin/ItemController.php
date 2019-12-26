<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\TitanFramework\Character;
use PbbgIo\TitanFramework\CharacterItem;
use PbbgIo\TitanFramework\CharacterStat;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateItemRequest;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateStatRequest;
use PbbgIo\TitanFramework\Item;
use PbbgIo\TitanFramework\ItemCategory;
use PbbgIo\TitanFramework\ItemStat;
use PbbgIo\TitanFramework\Stat;

/**
 * Class ItemController
 * @package PbbgIo\TitanFramework\Http\Controllers\Admin
 */
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('titan::admin.items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $item_categories = ItemCategory::all();
        return view('titan::admin.items.create', compact('item_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateItemRequest $request)
    {
        $item = new Item();
        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->cost = $request->input('cost', 0);
        $item->buyable = $request->has('buyable') ?? false;
        $item->consumable = $request->has('consumable') ?? false;
        $item->consumable_uses = $request->input('consumable_uses', 0) ?? 0;
        $item->equippable = $request->has('equippable');
        $item->stackable = $request->has('stackable');
        $item->item_category_id = $request->input('item_category_id');

        $item->save();

        foreach($request->input('stat_names') as $index => $stat_name)
        {
            $value = $request->input('stat_values')[$index];

            // Check if there is no name or value, ie blank box
            if(!$stat_name && !$value)
                continue;

            $stat = new ItemStat();
            $stat->key = $stat_name;
            $stat->value = $request->input('stat_values')[$index];
            $stat->item_id = $item->id;
            $stat->save();
        }

        flash("Item has been saved")->success();

        return redirect()->route('admin.items.edit', $item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item): View
    {
        $item_categories = ItemCategory::all();


        // This is a really ugly hack to make checkboxes work as they do strict type checking
        // and laravel casts it to bool... to "1" given from the form isn't 1.
        $item->casts = [];

        $item->consumable = (string) $item->consumable;
        $item->buyable = (string) $item->buyable;
        $item->equippable = (string) $item->equippable;
        $item->stackable = (string) $item->stackable;

        return view('titan::admin.items.edit', compact('item', 'item_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateItemRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function update(CreateUpdateItemRequest $request, Item $item): RedirectResponse
    {


        $item->name = $request->input('name');
        $item->description = $request->input('description');
        $item->cost = $request->input('cost', 0);
        $item->buyable = $request->has('buyable');
        $item->consumable = $request->has('consumable');
        $item->stackable = $request->has('stackable');
        $item->consumable_uses = $request->input('consumable_uses', 0) ?? 0;
        $item->equippable = $request->has('equippable');
        $item->item_category_id = $request->input('item_category_id');

        $item->save();

        $stats = [];

        foreach($request->input('stat_names') as $index => $stat_name)
        {
            $value = $request->input('stat_values')[$index];

            // Check if there is no name or value, ie blank box
            if(!$stat_name && !$value)
                continue;

            $stat = ItemStat::firstOrNew([
                'key'   =>  $stat_name,
                'item_id'   =>  $item->id
            ]);
            $stat->value = $request->input('stat_values')[$index];
            $stat->save();

            $stats[] = $stat->id;
        }

        // Clear out unassociated entries
        ItemStat::whereNotIn('id', $stats)
            ->where('item_id', $item->id)
            ->delete();

        flash("Item has been saved")->success();

        return redirect()->back();
    }

    /**
     * @param Item $item
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Item $item)
    {
        CharacterItem::whereItemId($item->id)->delete();
        ItemStat::whereItemId($item->id)->delete();
        $item->delete();
        flash("Item has been deleted")->success();

        return response()->json(['ok']);
    }

    /**
     * @return JsonResponse
     */
    public function datatable(): JsonResponse
    {
        return datatables(Item::select())
            ->addColumn('action', function ($item) {
                $routeEdit = route('admin.items.edit', $item);
                $routeDelete = route('admin.items.destroy', $item);
                $buttons = '';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
                $buttons .= '<a href="' . $routeDelete . '" class="btn btn-xs btn-danger delete"><i class="fas fa-times-circle fa-sm text-white-50"></i> Delete</a>';
                return $buttons;
            })
            ->addColumn('item_category', function($item) {
                return $item->category->name ?? 'Uncategorized';
            })
            ->toJson();
    }
}
