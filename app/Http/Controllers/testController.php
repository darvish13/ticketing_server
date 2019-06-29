<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testController extends Controller
{
    function test() {
        return response()->json('Test Success');
    }
}