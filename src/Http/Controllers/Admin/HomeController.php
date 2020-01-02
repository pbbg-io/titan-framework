<?php

namespace PbbgIo\Titan\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     * @throws \Exception
     */
    public function index(): View
    {
        $stats = [];
        $stats['players'] = User::count();
        $stats['version_update'] = $this->needsEngineUpdate();
        $stats['current_version'] = config('titan.version');
        $stats['latest_version'] = resolve('settings')->firstWhere('key', 'remote_version')->value ?? 0;
        $stats['players_online'] = User::where('last_move', '>', (new Carbon())->subHour())->count();
        $stats['players_registered_today'] = User::where('created_at', '>', (new Carbon())->startOfDay())->count();

        return view('titan::admin.home', compact('stats'));
    }

    public function needsEngineUpdate(): bool
    {
        $remoteEngineVersion = resolve('settings')->firstWhere('key', 'remote_version')->value ?? 0;
        $remoteVersion = version_compare(config('titan.version'), $remoteEngineVersion);

        return $remoteVersion === -1;
    }
}
