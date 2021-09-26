<?php

namespace App\Http\Controllers;

use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Http\Request;
use App\Http\Requests\UrlRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UrlsController extends Controller
{
    public function index(): View
    {
        $urls = Urls::paginate(10);

        return view('Urls/index', ['urls' => $urls]);
    }

    public function create(): View
    {
        return view('home');
    }

    public function store(Request $req, Urls $urls): RedirectResponse
    {
        $url = $req->input('url.name');
        $errors = $req->validate(['url.name' => 'required|max:255|url']);
        //$validator = Validator::make($req->input('url'), [
        //    'name' => ['required', 'url', 'max:255']
        //]);

        if (!$errors) {
            dd($errors);
            return back()->withErrors($errors);
        }

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

    public function show(Urls $urls, $id): View
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
