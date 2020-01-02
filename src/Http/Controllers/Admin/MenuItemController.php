<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MenuItemController extends Controller
{
    public function index() {
        return view('titan::admin.menu.item.index');
    }

    public function create() {
        return view('titan::admin.menu.item.create');

    }

    public function store() {

    }

    public function edit() {
        return view('titan::admin.menu.item.edit');

    }

    public function update() {

    }

    public function delete() {

    }

    public function destroy() {

    }
}
