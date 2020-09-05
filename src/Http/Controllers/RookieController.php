<?php

namespace NguyenTranChung\Rookie\Http\Controllers;

use Illuminate\Routing\Controller;

class RookieController extends Controller
{
    public function index($rookieName)
    {
        return view(config('rookie.view'));
    }
}
