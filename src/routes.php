<?php

Route::group(config('rookie.route', []), function () {
    Route::get('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@index')
        ->name('rookie.index');;

    Route::post('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@store')
        ->name('rookie.store');

    Route::put('{rookieName}/{rookieId}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@update')
        ->name('rookie.update');

    Route::get('{rookieName}/create', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@create')
        ->name('rookie.create');

    Route::get('{rookieName}/{rookieId}/edit', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@edit')
        ->name('rookie.edit');
});
