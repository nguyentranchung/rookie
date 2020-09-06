<?php

namespace NguyenTranChung\Rookie\Http\Controllers;

use Illuminate\Routing\Controller;

class RookieController extends Controller
{
    public function index($rookieName)
    {
        return view('rookie::index', compact('rookieName'));
    }

    public function create($rookieName)
    {
        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($value, $key) => $key === $rookieName)->firstOrFail();
        $rookie = new $rookie;

        return view('rookie::create', compact('rookieName'));
    }
}
