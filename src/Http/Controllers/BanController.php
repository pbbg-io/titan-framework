<?php

namespace PbbgIo\Titan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Ban;
use Illuminate\Database\Eloquent\Builder;

class BanController extends \App\Http\Controllers\Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ban = Ban::where(function(Builder $query) use (&$type) {
            if(session()->has('character_logged_in'))
            {
                $query->where('bannable_id', auth()->user()->character->id);
                $query->where('bannable_type', get_class(auth()->user()->character));
            }
        })->orWhere(function(Builder $query) use (&$type) {
            $query->where('bannable_id', auth()->user()->id);
            $query->where('bannable_type', get_class(auth()->user()));

        })->first();


        if($ban)
        {
            flash()->error('You are Banned!!');
            return view('titan::game.ban.index', compact('ban'));
        }
        else
        {
            return redirect()->route('game.home');
        }
    }

}
