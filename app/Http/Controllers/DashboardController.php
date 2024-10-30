<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Target, Result};

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $target = Target::all();
        $result = Result::all();
        return view('dashboard', compact('target','result','title'));
    }
}
