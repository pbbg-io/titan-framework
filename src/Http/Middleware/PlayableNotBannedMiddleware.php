<?php

namespace PbbgIo\Titan\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PbbgIo\Titan\Ban;
use Illuminate\Database\Eloquent\Builder;

class PlayableNotBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth($guard)->check() && !in_array($request->route()->getName(), config('banuser.excluded_routes'))) {
            $isBanned = Ban::where(function (Builder $query) {
                $query->where('bannable_id', auth()->user()->id);
                $query->where('bannable_type', get_class(auth()->user()));
            })
                ->orWhere(function (Builder $query) {
                    if (session()->has('character_logged_in')) {
                        $query->where('bannable_id', auth()->user()->character->id);
                        $query->where('bannable_type', get_class(auth()->user()->character));
                    }
                })->first();
            if ($isBanned) {
                if ($isBanned->forever == true || now()->diffInSeconds($isBanned->ban_until) > 0) {
                    return redirect()->route('userban.userbanned');
                } else {
                    $isBanned->delete();

                    return $next($request);
                }
            } else {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
