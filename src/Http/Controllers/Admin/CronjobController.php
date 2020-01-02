<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use PbbgIo\Titan\Cronjobs;
use PbbgIo\Titan\Http\Requests\CronCreateRequest;
use PbbgIo\Titan\Http\Requests\CronRunRequest;

class CronjobController extends Controller
{
    public function index(): View {
        $jobs = Cronjobs::all();
        return view('titan::admin.cronjobs.index', compact('jobs'));
    }

    public function create(): View {
        return view('titan::admin.cronjobs.create');
    }

    public function edit(Cronjobs $cronjob): View {

        return view('titan::admin.cronjobs.edit', compact('cronjob'));
    }

    public function update(CronCreateRequest $request, Cronjobs $cronjob): RedirectResponse {
        $cronjob->fill($request->all())->save();
        flash('Cron updated')->success();
        return back();
    }

    public function run(CronRunRequest $request): JsonResponse {
        $output = \Artisan::call($request->input('command'));
        return response()->json(\Artisan::output());
    }

    public function store(CronCreateRequest $request): RedirectResponse {
        $cron = new Cronjobs();
        $cron->command = $request->input('command');
        $cron->cron = $request->input('expression');
        $cron->enabled = $request->input('enabled', 0);
        $cron->save();

        return redirect()->route('admin.cronjobs.index');
    }

    public function destroy(Cronjobs $cronjob): JsonResponse {
        $cronjob->delete();
        flash("Cronjob deleted")->success();
        return response()->json(['ok']);
    }
}
