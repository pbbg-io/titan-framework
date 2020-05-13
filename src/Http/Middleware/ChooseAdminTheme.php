<?php

namespace PbbgIo\Titan\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class ChooseAdminTheme
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
        $theme = session()->get('admin-theme', config('titan.themes.admin'));

        \Theme::set($theme);

        return $next($request);
    }
}
