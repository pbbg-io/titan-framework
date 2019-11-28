<?php

namespace PbbgIo\TitanFramework\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Cronjobs;
use PbbgIo\TitanFramework\Http\Requests\CronCreateRequest;

class CronjobController extends Controller
{
    public function index() {
        $jobs = Cronjobs::all();
        return view('titan::admin.cronjobs.index', compact('jobs'));
    }

    public function create() {
        return view('titan::admin.cronjobs.create');
    }

    public function store(CronCreateRequest $request) {
        $cron = new Cronjobs();
        $cron->command = $request->input('command');
        $cron->cron = $request->input('expression');
        $cron->enabled = $request->input('enabled', 0);
        $cron->save();

        return redirect()->route('admin.cronjobs.index');
    }

    public function destroy(Cronjobs $cronjob) {
        $cronjob->delete();
    }
}
