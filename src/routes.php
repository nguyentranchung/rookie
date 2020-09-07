<?php

Route::group(config('rookie.route', []), function () {
    Route::get('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@index')
        ->name('rookie.index');;

    Route::post('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@store')
        ->name('rookie.store');

    Route::get('{rookieName}/create', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@create')
        ->name('rookie.create');
});
