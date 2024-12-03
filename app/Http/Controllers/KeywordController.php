<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Keyword';
        $keyword = Keyword::all();
        $breadcrumb = [
            ['label' => 'Keyword'],
        ];
        return view('keyword.index', compact('title', 'keyword','breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Keyword';
        $breadcrumb = [
            ['label' => 'Keyword', 'route' => route('keyword.index')],
            ['label' => 'Tambah Keyword'],
        ];
        return view('keyword.create', compact('title', 'breadcrumb'));
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
                'keyword' => 'required',
            ],
            [
                'keyword.required' => 'Harap untuk mengisi kolom keyword',
            ],
        );

        $keyword = Keyword::create([
            'keyword' => $request->input('keyword'),
            'slug' => Str::lower($request->input('keyword')),
        ]);

        return redirect()->route('keyword.index')->with('success', 'Berhasil menambahkan keyword');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function show(keyword $keyword)
    {
        $title = 'Keyword';
        $breadcrumb = [
            ['label' => 'Keyword', 'route' => route('keyword.index')],
            ['label' => 'Detail Keyword'],
        ];
        return view('keyword.show', compact('title', 'breadcrumb', 'keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit(keyword $keyword)
    {
        $title = 'Keyword';
        $breadcrumb = [
            ['label' => 'Keyword', 'route' => route('keyword.index')],
            ['label' => 'Edit Keyword'],
        ];
        return view('keyword.edit', compact('title', 'breadcrumb', 'keyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, keyword $keyword)
    {
        $request->validate(
            [
                'keyword' => 'required',
            ],
            [
                'keyword.required' => 'Harap untuk mengisi kolom keyword',
            ],
        );

        $keyword->update([
            'keyword' => $request->input('keyword'),
            'slug' => Str::lower($request->input('keyword')),
        ]);
        return redirect()->route('keyword.index')->with('success', 'Berhasil mengubah keyword');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\keyword  $keyword
     * @return \Illuminate\Http\Response
     */
    public function destroy(keyword $keyword)
    {
        $keyword->delete();
        return redirect()->route('keyword.index')->with('success', 'Berhasil menghapus keyword');
    }
}
