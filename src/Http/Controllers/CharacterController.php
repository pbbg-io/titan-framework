<?php

namespace PbbgIo\TitanFramework\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PbbgIo\TitanFramework\Character;
use PbbgIo\TitanFramework\Http\Requests\CreateCharacterRequest;

class CharacterController extends Controller
{
    public function index() {
        $characters = \Auth::user()->characters;
        return view('titan::character.choice.index', compact('characters'));
    }

    public function create(CreateCharacterRequest $request) {
        $character = new Character();
        $character->user_id = \Auth::user()->id;
        $character->display_name = $request->input('name');
        $character->area_id = mt_rand(1, 3);
        $character->last_move = new Carbon();
        $character->save();

        $character->seedStats();

        session()->put('character_logged_in', $character->id);

        return redirect()->route('game.home');
    }

    public function choose() {
        $char = \Auth::user()->characters->where('id', request()->input('id'))->first();

        session()->put('character_logged_in', $char->id);

        return redirect()->route('game.home');
    }
}
