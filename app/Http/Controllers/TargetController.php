<?php

namespace App\Http\Controllers;

use App\Models\{Target, Selector};
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Target';
        $target = Target::all();
        return view('target.index', compact('title','target'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Target';
        $subtitle = 'Tambah Target';
        return view('target.create', compact('title','subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url'
        ],[
            'name.required' => 'Harap mengisi nama website target',
            'url.required' => 'Harap mengisi alamat website target',
            'url.url' => 'Harap mengisi url yang valid',
        ]);

        $target = Target::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
        ]);
        if ($target) {
            $selector = Selector::create([
                'target_id' => $target->id
            ]);
        }

        return redirect()->route('target.index')->with('success', 'Berhasil menambahkan target');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function show(Target $target)
    {
        $title = 'Target';
        $subtitle = 'Detail Target';
        return view('target.show', compact('title','subtitle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Target $target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Target  $target
     * @return \Illuminate\Http\Response
     */
    public function destroy(Target $target)
    {
        //
    }
}
