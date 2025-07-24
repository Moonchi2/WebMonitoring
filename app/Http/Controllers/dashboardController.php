<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
     public function index()
    {
        $type_menu = 'dashboard';
        // arahkan ke file pages/gurus/create.blade.php
        return view('pages.dashboard.index', compact('type_menu'));
    }
}
