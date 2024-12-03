<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Target, Result, Keyword};

class DashboardController extends Controller
{
    public function index()
    {
        $target = Target::all();
        $result = Result::all();
        $keyword = Keyword::all();
        $breadcrumb = [
            ['label' => 'Dashboard']
        ];
        return view('dashboard', compact('target','result','keyword','breadcrumb'));
    }
}
