<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Client\HttpClientException;

class UrlsController extends Controller
{
    public function index(): View
    {
        $urls = DB::table('urls')->orderBy('id')->paginate(10);
        $checks = DB::table('url_checks')
            ->orderBy('updated_at')
            ->get()
            ->keyBy('url_id');

        return view('Urls/index', ['urls' => $urls, 'checks' => $checks]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'url.name' => ['required', 'url', 'max:255']
        ]);

        if ($validator->fails()) {
            flash("Некорректный URL: {$request->input('url.name')}")->error();
            return back()->withErrors($validator);
        }
        $urlName = $validator->safe();
        ['scheme' => $scheme, 'host' => $host ] = parse_url($urlName['url']['name']);
        $name = "{$scheme}://{$host}";

        if (DB::table('urls')->where('name', '=', $name)->exists()) {
            $id = DB::table('urls')
            ->where('name', '=', $name)
            ->value('id');

            flash('Страница уже существует')->info();
            return redirect()->route('urls.show', $id);
        }

        $id = DB::table('urls')->insertGetId(['name' => $name]);

        flash('Страница успешно добавлена')->success();
        return redirect()->route('urls.show', $id);
    }

    public function show(int $id): View
    {
        $checks = DB::table('url_checks')
            ->where('url_id', $id)
            ->orderByDesc('created_at')
            ->get();

        $url = DB::table('urls')->find($id);

        return view('Urls/show', [
            'url' => $url,
            'checks' => $checks
        ]);
    }
}
