<?php

Route::group(config('rookie.route', []), function () {
    Route::get('{rookieName}', '\NguyenTranChung\Rookie\Http\Controllers\RookieController@index');
});
