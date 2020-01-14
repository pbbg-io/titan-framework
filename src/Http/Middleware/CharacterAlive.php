<?php

namespace PbbgIo\Titan\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class CharacterAlive
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
        if(\Auth::user()->character->getStat('alive') === true)
        {
            return $next($request);
        }
        $name = \Auth::user()->character->display_name;

        flash("Your Character ${name} died")->warning();

        return redirect()->route('character.choose.index');
    }
}
