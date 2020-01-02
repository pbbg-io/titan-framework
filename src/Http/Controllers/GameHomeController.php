<?php

namespace PbbgIo\Titan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameHomeController extends Controller
{
    public function index() {
        return view('titan::game.home');
    }
}
