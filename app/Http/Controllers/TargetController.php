<?php

namespace App\Http\Controllers;

use App\Models\{Target, Selector};
use Illuminate\Http\Request;
use Goutte;

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
        return view('target.index', compact('title', 'target'));
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
        return view('target.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'url' => 'required|url',
            ],
            [
                'name.required' => 'Harap mengisi nama website target',
                'url.required' => 'Harap mengisi alamat website target',
                'url.url' => 'Harap mengisi url yang valid',
            ],
        );

        $target = Target::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
        ]);
        if ($target) {
            $selector = Selector::create([
                'target_id' => $target->id,
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
        return view('target.show', compact('title', 'subtitle', 'target'));
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

    public function addSelector(Target $target)
    {
        $title = 'Target';
        $subtitle = 'Tambah Selector';
        return view('target.addSelector', compact('title', 'subtitle', 'target'));
    }

    public function saveSelector(Request $request, Target $target)
    {
        $request->validate([
            'headline' => 'required',
            'date' => 'required',
            'link' => 'required',
            'content' => 'required',
            'cover' => 'required',
            'tag' => 'required',
        ],[
            'headline.required' => 'Harap isi kolom headline selector',
            'date.required' => 'Harap isi kolom date selector',
            'link.required' => 'Harap isi kolom link selector',
            'content.required' => 'Harap isi kolom content selector',
            'cover.required' => 'Harap isi kolom cover selector',
            'tag.required' => 'Harap isi kolom tag selector',
        ]);


        $target->selector->update([
            'target_id' => $target->id,
            'headline' => $request->input('headline'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover'),
            'tags' => $request->input('tag'),
        ]);
        return redirect()->route('target.show', $target->id)->with('success', 'Berhasil menambahkan selector untuk target : ' . $target->name);
    }

    public function editSelector(Target $target)
    {
        $title = 'Target';
        $subtitle = 'Edit Selector';
        return view('target.editSelector', compact('title', 'subtitle', 'target'));
    }

    public function updateSelector(Request $request, Target $target)
    {
        $request->validate([
            'headline' => 'required',
            'date' => 'required',
            'link' => 'required',
            'content' => 'required',
            'cover' => 'required',
            'tag' => 'required',
        ],[
            'headline.required' => 'Harap isi kolom headline selector',
            'date.required' => 'Harap isi kolom date selector',
            'link.required' => 'Harap isi kolom link selector',
            'content.required' => 'Harap isi kolom content selector',
            'cover.required' => 'Harap isi kolom cover selector',
            'tag.required' => 'Harap isi kolom tag selector',
        ]);


        $target->selector->update([
            'target_id' => $target->id,
            'headline' => $request->input('headline'),
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'content' => $request->input('content'),
            'cover' => $request->input('cover'),
            'tags' => $request->input('tag'),
        ]);
        return redirect()->route('target.show', $target->id)->with('success', 'Berhasil mengubah selector untuk target : ' . $target->name);
    }
}
