<?php

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'permission:admin', 'update_last_move'],
], function () {
    Route::get('/', 'HomeController@index')
        ->name('admin.home');

    Route::get('/extensions', 'ExtensionController@index')
        ->name('admin.extensions.index');

    Route::get('/extensions/{slug}', 'ExtensionController@showMarketplacePage')
        ->name('admin.extensions.show');

    Route::get('/extensions/{slug}/manage', 'ExtensionController@manage')
        ->name('admin.extensions.manage');

    Route::get('/extensions/{slug}/install', 'ExtensionController@install')
        ->name('admin.extensions.install');

    Route::get('/extensions/{slug}/uninstall', 'ExtensionController@uninstall')
        ->name('admin.extensions.uninstall');

    Route::get('/users/datatable', 'UserController@datatable')
        ->name('admin.users.datatable');

    Route::post('/cronjobs/run', 'CronjobController@run')
        ->name('admin.cronjobs.run');

    Route::resource('cronjobs', 'CronjobController')->names([
        'index' => 'admin.cronjobs.index',
        'create' => 'admin.cronjobs.create',
        'store' => 'admin.cronjobs.store',
        'update' => 'admin.cronjobs.update',
        'edit' => 'admin.cronjobs.edit',
        'delete' => 'admin.cronjobs.delete',
        'destroy' => 'admin.cronjobs.destroy',
    ]);

    Route::get('users/list', 'UserController@list')
        ->name('admin.users.list');

    Route::resource('users', 'UserController')->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'update' => 'admin.users.update',
        'edit' => 'admin.users.edit',
        'delete' => 'admin.users.delete',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::get('/characters/datatable', 'CharacterController@datatable')
        ->name('admin.characters.datatable');

    Route::resource('characters', 'CharacterController')
        ->names([
            'index' => 'admin.characters.index',
            'create' => 'admin.characters.create',
            'store' => 'admin.characters.store',
            'update' => 'admin.characters.update',
            'edit' => 'admin.characters.edit',
            'delete' => 'admin.characters.delete',
            'destroy' => 'admin.characters.destroy',
        ]);

    Route::get('/areas/datatable', 'AreaController@datatable')
        ->name('admin.areas.datatable');

    Route::resource('areas', 'AreaController')
        ->names([
            'index' => 'admin.areas.index',
            'create' => 'admin.areas.create',
            'store' => 'admin.areas.store',
            'update' => 'admin.areas.update',
            'edit' => 'admin.areas.edit',
            'delete' => 'admin.areas.delete',
            'destroy' => 'admin.areas.destroy',
        ]);

    Route::get('/stats/datatable', 'StatController@datatable')
        ->name('admin.stats.datatable');

    Route::resource('stats', 'StatController')
        ->names([
            'index' => 'admin.stats.index',
            'create' => 'admin.stats.create',
            'store' => 'admin.stats.store',
            'update' => 'admin.stats.update',
            'edit' => 'admin.stats.edit',
            'delete' => 'admin.stats.delete',
            'destroy' => 'admin.stats.destroy',
        ]);

    Route::get('/items/datatable', 'ItemController@datatable')
        ->name('admin.items.datatable');

    Route::resource('items', 'ItemController')
        ->names([
            'index' => 'admin.items.index',
            'create' => 'admin.items.create',
            'store' => 'admin.items.store',
            'update' => 'admin.items.update',
            'edit' => 'admin.items.edit',
            'delete' => 'admin.items.delete',
            'destroy' => 'admin.items.destroy',
        ]);

    Route::get('/item-categories/datatable', 'ItemCategoryController@datatable')
        ->name('admin.item-categories.datatable');

    Route::resource('item-categories', 'ItemCategoryController')
        ->names([
            'index' => 'admin.item-categories.index',
            'create' => 'admin.item-categories.create',
            'store' => 'admin.item-categories.store',
            'update' => 'admin.item-categories.update',
            'edit' => 'admin.item-categories.edit',
            'delete' => 'admin.item-categories.delete',
            'destroy' => 'admin.item-categories.destroy',
        ]);

    Route::resource('groups', 'GroupController')->names([
        'index' => 'admin.groups.index',
        'create' => 'admin.groups.create',
        'store' => 'admin.groups.store',
        'update' => 'admin.groups.update',
        'edit' => 'admin.groups.edit',
        'delete' => 'admin.groups.delete',
        'destroy' => 'admin.groups.destroy',
    ]);

    Route::post('/search', 'SearchController@index')
        ->name('admin.search');

    Route::resource('menus', 'MenuController')->names([
        'index' => 'admin.menu.index',
        'create' => 'admin.menu.create',
        'store' => 'admin.menu.store',
        'update' => 'admin.menu.update',
        'edit' => 'admin.menu.edit',
        'delete' => 'admin.menu.delete',
        'destroy' => 'admin.menu.destroy',
    ]);

    Route::put('menu/items/{menu}/sort', 'MenuController@sort')
        ->name('admin.menu.sort');

    Route::post('menu/items/{menu}/item', 'MenuController@addItem')
        ->name('admin.menu.add');

    Route::delete('menu/items', 'MenuController@deleteItem')
        ->name('admin.menu.item.delete');

    Route::get('logs', 'LogController@index')
        ->name('admin.logs.index');


    Route::get('banlist', 'BanController@index')->name('admin.banuser.index');
    Route::get('unban/{playable}', 'BanController@destroy')->name('admin.banuser.unban');
    Route::match(['GET'], 'ban/datatables', 'BanController@dataTable')->name('admin.banuser.datatable');
    Route::group([
        'middleware' => ['permission:ban-user'],
    ], function() {
        Route::resource('banuser', 'BanUserController')->names([
            'create' => 'admin.banuser.create',
            'store' => 'admin.banuser.store',
            'update' => 'admin.banuser.update',
            'edit' => 'admin.banuser.edit',
        ])->except(['index', 'destroy']);
        Route::resource('banchar', 'BanCharController')->names([
            'create' => 'admin.banchar.create',
            'store' => 'admin.banchar.store',
            'update' => 'admin.banchar.update',
            'edit' => 'admin.banchar.edit',
        ])->except(['index', 'destroy']);
    });

});
