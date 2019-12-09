<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\TitanFramework\Http\Requests\CreateUpdateMenuRequest;
use PbbgIo\TitanFramework\Http\Requests\MenuItemCreateRequest;
use PbbgIo\TitanFramework\Menu;
use PbbgIo\TitanFramework\MenuItem;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::all();
        return view('titan::admin.menu.index', compact('menus'));
    }

    public function create(): View
    {
        return view('titan::admin.menu.create');

    }

    public function store(CreateUpdateMenuRequest $request): RedirectResponse
    {
        $menu = new Menu();
        $menu->name = $request->input('name');
        $menu->enabled = false;
        $menu->save();

        flash("Menu has been created")->success();

        return redirect()->route('admin.menu.edit', $menu);
    }

    public function edit($menu): View
    {
        $menu = Menu::with('items')->find($menu);

        return view('titan::admin.menu.edit', compact('menu'));
    }

    public function sort(Menu $menu, Request $request): void
    {

        $order = 0;
        $ids = [];

        foreach ($request->input('menu') as $menu) {

            $mItem = MenuItem::find($menu['id']);
            $mItem->parent_id = $menu['parent_id'];
            $mItem->order = $order;
            $mItem->save();

            $ids[] = $mItem->id;
            $order++;
        }

        // Sync deletions
        MenuItem::whereNotIn('id', $ids)
            ->where('menu_id', $mItem->menu_id)
            ->delete();
    }

    public function addItem(MenuItemCreateRequest $request): JsonResponse
    {
        $item = new MenuItem();
        $item->name = $request->input('itemName');
        $item->route = $request->input('itemLink');
        $item->menu_id = $request->menu;
        $item->save();

        return response()->json([
            'name' => $item->name,
            'id' => $item->id
        ]);
    }

    public function update(CreateUpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $menu->name = $request->input('name');
        $menu->save();

        flash("Menu has been updated")->success();

        return redirect()->back();
    }

    public function destroy(Menu $menu): void
    {
        $menu->items()->delete();
        $menu->delete();

        flash("Menu has been deleted")->success();

//        return redirect()->route('admin.menu.index');
    }
}
