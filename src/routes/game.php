<?php

Route::get('/', function() {
    return redirect()->route('game.home');
});

Route::group([
    'prefix' => 'game',
    'middleware' => ['auth', 'character_logged_in', 'character_alive', 'choose_game_theme']
], function () {
    Route::get('/', 'GameHomeController@index')->name('game.home');
    Route::get('banned', 'BanController@index')->name('userban.userbanned');
});
