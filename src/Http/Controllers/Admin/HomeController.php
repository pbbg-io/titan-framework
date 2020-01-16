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
        $stats['current_version'] = config('titan.version');
        $stats['players_online'] = User::where('last_move', '>', (new Carbon())->subHour())->count();
        $stats['players_registered_today'] = User::where('created_at', '>', (new Carbon())->startOfDay())->count();

        return view('titan::admin.home', compact('stats'));
    }
}
