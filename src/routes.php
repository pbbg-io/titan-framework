<?php
Route::group([
    'namespace' => 'PbbgIo\Titan\Http\Controllers',
    'middleware' => [
        'web'
    ]
], function () {

    include __DIR__ . '/routes/auth.php';

    include __DIR__ . '/routes/game.php';

    include __DIR__ . '/routes/admin.php';

});
