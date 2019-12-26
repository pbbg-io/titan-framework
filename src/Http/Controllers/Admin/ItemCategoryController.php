<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\TitanFramework\CharacterItem;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateItemCategoryRequest;
use PbbgIo\TitanFramework\Item;
use PbbgIo\TitanFramework\ItemCategory;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): View
    {
        return view('titan::admin.item-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): View
    {
        return view('titan::admin.item-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateUpdateItemCategoryRequest $request)
    {
        $category = new ItemCategory();
        $category->name = $request->input('name');
        $category->equippable = $request->has('equippable') ?? false;
        $category->stackable = $request->has('stackable') ?? false;
        $category->consumable = $request->has('consumable') ?? false;
        $category->consumable_uses = $request->input('consumable_uses') ?? 0;
        $category->buyable = $request->has('buyable') ?? false;
        $category->save();

        flash("Item Category created")->success();

        return redirect()->route('admin.item-categories.edit', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItemCategory $item_category
     * @return View
     */
    public function edit(ItemCategory $item_category): View
    {
        $item_category->casts = [];

        $item_category->consumable = (string) $item_category->consumable;
        $item_category->buyable = (string) $item_category->buyable;
        $item_category->equippable = (string) $item_category->equippable;
        $item_category->stackable = (string) $item_category->stackable;

        return view('titan::admin.item-categories.edit', compact('item_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(CreateUpdateItemCategoryRequest $request, ItemCategory $item_category)
    {
        $item_category->name = $request->input('name');
        $item_category->equippable = $request->has('equippable') ?? false;
        $item_category->stackable = $request->has('stackable') ?? false;
        $item_category->consumable = $request->has('consumable') ?? false;
        $item_category->consumable_uses = $request->input('consumable_uses') ?? 0;
        $item_category->buyable = $request->has('buyable') ?? false;
        $item_category->save();

        flash("Item Category created")->success();

        return redirect()->route('admin.item-categories.edit', $item_category);
    }

    /**
     * @param ItemCategory $item_category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ItemCategory $item_category)
    {
        Item::whereItemCategoryId($item_category->id)
            ->update([
                'item_category_id'  =>  null
            ]);

        $item_category->delete();
        flash("Item category has been deleted")->success();

        return response()->json(['ok']);
    }

    /**
     * @return JsonResponse
     */
    public function datatable(): JsonResponse
    {
        return datatables(ItemCategory::select())
            ->addColumn('action', function ($item) {
                $routeEdit = route('admin.item-categories.edit', $item);
                $routeDelete = route('admin.item-categories.destroy', $item);
                $buttons = '';
                $buttons .= '<a href="' . $routeEdit . '" class="btn btn-xs btn-primary mr-3"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>';
                $buttons .= '<a href="' . $routeDelete . '" class="btn btn-xs btn-danger delete"><i class="fas fa-times-circle fa-sm text-white-50"></i> Delete</a>';
                return $buttons;
            })
            ->toJson();
    }
}
