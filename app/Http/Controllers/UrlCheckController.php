<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use Illuminate\Http\Client\HttpClientException;

class UrlCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);

        try {
            $response = Http::timeout(3)->get($url->name);
            $document = new Document($response->body());
        } catch (HttpClientException $exception) {
            flash($exception->getMessage())->error();
            return redirect()->route('urls.show', $id);
        }

        DB::table('url_checks')->insert([
            'url_id' => $id,
            'status_code' => $response->status(),
            'h1' => optional($document->first('h1'))->text(),
            'keywords' => optional($document->first('meta[name=keywords]'))->attr('content'),
            'description' => optional($document->first('meta[name=description]'))->attr('content'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('urls')->where('id', '=', $id)->update(['updated_at' => now()]);

        flash("Страница успешно проверена")->info();
        return redirect()
        ->route('urls.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
