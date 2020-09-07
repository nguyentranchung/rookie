<?php

namespace NguyenTranChung\Rookie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RookieController extends Controller
{
    public function index($rookieName)
    {
        return view('rookie::index', compact('rookieName'));
    }

    public function create($rookieName)
    {
        $rookie = $this->findRookie($rookieName);

        return view('rookie::create', compact('rookieName', 'rookie'));
    }

    public function store(Request $request, $rookieName)
    {
        $rookie = $this->findRookie($rookieName);
        return $rookie->store($request);
    }

    protected function findRookie($rookieName)
    {
        config()->set('form-components.framework', 'bootstrap-4');
        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($value, $key) => $key === $rookieName)->firstOrFail();
        return new $rookie;
    }
}
