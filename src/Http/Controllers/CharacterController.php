<?php

namespace PbbgIo\Titan\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\Titan\Character;
use PbbgIo\Titan\Http\Requests\CreateCharacterRequest;

class CharacterController extends Controller
{
    public function index() {
        $user = \Auth::user();
        $characters = $user->characters;

        if($user->last_character_played && request()->headers->get('referer', route('game.home')) !== route('game.home'))
        {
            $char = $characters->filter(function($character) use($user) {
                return $character->id === $user->last_character_played;
            });

            // Check they are alive
            if($char->count() === 1 && $char->first()->getStat('alive') === true)
            {
                session()->put('character_logged_in', $user->last_character_played);
                return redirect()->route('game.home');
            }
        }

        return view('titan::character.choice.index', compact('characters'));
    }

    public function create(CreateCharacterRequest $request) {

        if(count(\Auth::user()->getAliveCharacters()) >= config('game.max_alive_characters'))
        {
            flash("You have already created as many characters as allowed")->error();
            return redirect()->back();
        }


        $character = new Character();
        $character->user_id = \Auth::user()->id;
        $character->display_name = $request->input('name');
        $character->area_id = config('game.default_area_id');
        $character->last_move = new Carbon();
        $character->save();

        $character->seedStats();

        session()->put('character_logged_in', $character->id);

        $user = \Auth::user();
        $user->last_character_played = $character->id;
        $user->save();

        return redirect()->route('game.home');
    }

    public function choose() {
        $char = \Auth::user()->characters->where('id', request()->input('id'))->first();

        session()->put('character_logged_in', $char->id);

        $user = \Auth::user();
        $user->last_character_played = $char->id;
        $user->save();

        return redirect()->route('game.home');
    }
}
