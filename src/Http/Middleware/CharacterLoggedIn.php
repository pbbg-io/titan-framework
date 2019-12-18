<?php

namespace PbbgIo\TitanFramework\Http\Middleware;

use Carbon\Carbon;
use Closure;

class CharacterLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('character_logged_in'))
        {
            $char = \Auth::user()->character;

            if(!$char)
            {
                return redirect()->route('character.choose.index');
            }

            $char->last_move = new Carbon();
            $char->save();

            return $next($request);
        }

        return redirect()->route('character.choose.index');
    }
}
