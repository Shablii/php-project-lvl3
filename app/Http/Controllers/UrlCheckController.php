<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use Illuminate\Http\Client\HttpClientException;

class UrlCheckController extends Controller
{
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
}
