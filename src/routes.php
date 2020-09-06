<?php

Route::group(config('rookie.route', []), function () {
    Route::get('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@index')
        ->name('rookie.index');;
    Route::get('{rookieName}/create', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@index')
        ->name('rookie.create');
});
