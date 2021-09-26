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
    public function index()
    {
        $urls = Urls::paginate(10);

        return view('Urls/index', ['urls' => $urls]);
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
    public function store(Request $req, Urls $urls)
    {
        $validated = $req->validate(['name' => 'required|max:255|url']);

        ['scheme' => $scheme, 'host' => $host ] = parse_url($req->input('url.name'));
        $name = "{$scheme}://{$host}";

        if (DB::table('urls')->where('name', '=', $name)->exists()) {
            $id = DB::table('urls')
            ->where('name', '=', $name)
            ->value('id');

            return redirect()
            ->route('urls.show', $id)
            ->with('flash_message', [
                'class' => 'info',
                'message' => 'Страница уже существует'
            ]);
        }
        $urls->name = $name;
        $urls->save();

        return redirect()
        ->route('urls.show', $urls->id)
        ->with('flash_message', [
            'class' => 'success',
            'message' => 'Страница успешно добавлена'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Urls  $urls
     * @return \Illuminate\Http\Response
     */
    public function show(Urls $urls, $id)
    {
        $urlChecks = DB::table('url_checks')
            ->where('url_id', $id)
            ->orderByDesc('created_at')
            ->get();
        $url = $urls->find($id);

        return view('Urls/show', ['url' => $url]);
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
