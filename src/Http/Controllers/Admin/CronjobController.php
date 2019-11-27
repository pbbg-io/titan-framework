<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Cronjobs;

class CronjobController extends Controller
{
    public function index() {
        $jobs = Cronjobs::all();
        return view('titan::admin.cronjobs.index', compact('jobs'));
    }
}
