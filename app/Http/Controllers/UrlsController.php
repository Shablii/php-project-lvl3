<?php

namespace App\Http\Controllers;

use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Http\Request;
use App\Http\Requests\UrlRequest;
use Illuminate\Support\Facades\DB;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UrlChecks $urlChecks)
    {
        $urls = Urls::all();

        return view('Urls/index', [
            'urls' => $urls,
            'urlChecks' => $urlChecks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UrlRequest $req, Urls $urls)
    {
        $urls->name = $req->input('url.name');
        $urls->save();

        return redirect()
        ->route('urls.show', $urls)
        ->with('success', 'Страница успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Urls  $urls
     * @return \Illuminate\Http\Response
     */
    public function show(Urls $urls, $id)
    {
        $urlChecks = DB::table('url_checks')->where('url_id', $id)->get();

        return view('Urls/show', [
            'url' => $urls->find($id),
            'urlChecks' => $urlChecks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Urls  $urls
     * @return \Illuminate\Http\Response
     */
    public function edit(Urls $urls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Urls  $urls
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Urls $urls)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Urls  $urls
     * @return \Illuminate\Http\Response
     */
    public function destroy(Urls $urls)
    {
        //
    }
}
