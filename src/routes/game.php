<?php

Route::get('/', function() {
    return redirect()->route('game.home');
});

Route::group([
    'prefix' => 'game',
    'middleware' => ['auth', 'character_logged_in', 'character_alive']
], function () {
    Route::get('/', 'GameHomeController@index')->name('game.home');
});
