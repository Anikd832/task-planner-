<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class WebController extends Controller
{
    /**
     * redirect to application index page, Web
     */
    public function index(): View
    {
        return view('frontend');
    }
}
