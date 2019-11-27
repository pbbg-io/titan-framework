<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View {
        $settings = resolve('settings');
        return view('titan::admin.settings.index', compact('settings'));
    }
}
