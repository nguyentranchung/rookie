<?php

namespace NguyenTranChung\Rookie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use NguyenTranChung\Rookie\Rookie;

class RookieController extends Controller
{
    public function index($rookieName)
    {
        return view('rookie::index', compact('rookieName'));
    }

    public function create($rookieName)
    {
        $rookie = Rookie::findOrFail($rookieName);
        $model = null;

        return view('rookie::create', compact('rookieName', 'rookie', 'model'));
    }

    public function store(Request $request, $rookieName)
    {
        $rookie = Rookie::findOrFail($rookieName);

        return $rookie->store($request, $rookieName);
    }

    public function edit($rookieName, $rookieId)
    {
        $rookie = Rookie::findOrFail($rookieName);

        $model = $rookie->query()->find($rookieId);

        return view('rookie::create', compact('rookieName', 'rookieId', 'rookie', 'model'));
    }

    public function update(Request $request, $rookieName, $rookieId)
    {
        $rookie = Rookie::findOrFail($rookieName);

        return $rookie->update($request, $rookieName, $rookieId);
    }
}
