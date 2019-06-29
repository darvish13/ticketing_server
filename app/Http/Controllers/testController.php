<?php

namespace App\Http\Controllers;

class testController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test Success', 'user' => auth()->user()]);
    }
}
