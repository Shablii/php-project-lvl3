<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
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

    public function create(): View
    {
        return view('home');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->input('url'), [
            'name' => ['required', 'url', 'max:255']
        ]);

        if ($validator->fails()) {
            return back()->withErrors("Некорректный URL: {$request->input('url.name')}");
        }

        ['scheme' => $scheme, 'host' => $host ] = parse_url($request->input('url.name'));
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

        $id = DB::table('urls')->insertGetId(['name' => $name]);

        return redirect()
        ->route('urls.show', $id)
        ->with('flash_message', [
            'class' => 'success',
            'message' => 'Страница успешно добавлена'
        ]);
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

    public function checks(int $id): RedirectResponse
    {
        $url = DB::table('urls')->find($id);

        try {
            $response = Http::timeout(3)->get($url->name);
            $document = new Document($response->body());
        } catch (HttpClientException $exception) {
            return redirect()
            ->route('urls.show', ['url' => $id])
            ->with('flash_message', [
                'class' => 'danger',
                'message' => $exception->getMessage()
            ]);
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

        return redirect()
        ->route('urls.show', ['url' => $id])
        ->with('flash_message', [
            'class' => 'info',
            'message' => 'Страница успешно проверена'
        ]);
    }
}
