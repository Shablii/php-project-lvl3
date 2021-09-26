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

        $validator = Validator::make($req->input('url'), [
            'name' => ['required', 'url', 'max:255']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
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

    public function show(Urls $urls, int $id): View
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
