<?php
Route::group([
    'namespace' => 'PbbgIo\TitanFramework\Http\Controllers',
    'middleware' => [
        'web'
    ]
], function () {

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Password Confirmation Routes...

    Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...

    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'permission:admin'],
    ], function () {
        Route::get('/', 'HomeController@index')
            ->name('admin.home');

        Route::get('/extensions', 'ExtensionController@index')
            ->name('admin.extensions.index');

        Route::get('/extensions/{slug}', 'ExtensionController@manage')
            ->name('admin.extensions.manage');

        Route::get('/extensions/{slug}/install', 'ExtensionController@install')
            ->name('admin.extensions.install');

        Route::get('/extensions/{slug}/uninstall', 'ExtensionController@uninstall')
            ->name('admin.extensions.uninstall');

        Route::get('/users', 'UserController@index')
            ->name('admin.users.index');

        Route::get('/users/datatable', 'UserController@datatable')
            ->name('admin.users.datatable');

        Route::get('users/create', 'UserController@create')
            ->name('admin.users.create');

        Route::post('users/create', 'UserController@store')
            ->name('admin.users.store');

        Route::get('/users/{user}', 'UserController@edit')
            ->name('admin.users.edit');

        Route::post('/users/{user}', 'UserController@update')
            ->name('admin.users.update');


        Route::resource('cronjobs', 'CronjobController')->names([
            'index'    =>  'admin.cronjobs.index',
            'create'    =>  'admin.cronjobs.create',
            'store'    =>  'admin.cronjobs.store',
            'update'    =>  'admin.cronjobs.update',
            'edit'    =>  'admin.cronjobs.edit',
            'delete'    =>  'admin.cronjobs.delete',
            'destroy'    =>  'admin.cronjobs.destroy',
        ]);

        Route::get('/settings', 'SettingController@index')
            ->name('admin.settings.index');

        Route::get('/settings/{setting}', 'SettingController@edit')
            ->name('admin.settings.edit');

        Route::post('/settings/{setting}', 'SettingController@update')
            ->name('admin.settings.update');
    });

});
