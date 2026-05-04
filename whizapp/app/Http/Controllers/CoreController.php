<?php

namespace App\Http\Controllers;

class CoreController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        return view('landing');
    }
}
