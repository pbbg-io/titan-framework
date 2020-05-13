<?php

namespace PbbgIo\Titan\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class ChooseGameTheme
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $theme = session()->get('game-theme', config('titan.themes.game'));

        \Theme::set($theme);

        return $next($request);
    }
}
