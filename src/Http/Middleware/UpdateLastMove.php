<?php

namespace PbbgIo\Titan\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class UpdateLastMove
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
        if(\Auth::user())
        {
            $u = \Auth::user();
            $u->last_move = new Carbon();
            $u->save();
        }
        return $next($request);
    }
}
