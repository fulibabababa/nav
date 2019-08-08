<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function employ()
    {
        return view('employ');
    }
}
