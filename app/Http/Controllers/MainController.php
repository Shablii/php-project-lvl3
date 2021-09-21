<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urls;
use App\Models\UrlChecks;
use App\Http\Requests\UrlRequest;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    public function urlsAdd(UrlRequest $req)
    {
        $valid = $req->validate([ 'url.name' => 'required|max:255 ']);

        $url = new Urls();
        $url->name = $req->input('url.name');

        $url->save();

        return redirect()->route('urlShow', ['id' => $url->id])->with('success', 'Страница успешно добавлена');
    }
    public function urls()
    {
        $urls = new Urls();
        return view('urls', ['urls' => $urls->all()]);
    }

    public function home()
    {
        return view('home');
    }

    public function checks($id, UrlChecks $urlChecks, Urls $url)
    {
        $statusCode = Http::get($url->find($id)->name)->getStatusCode();

        $urlChecks->url_id = $id;
        $urlChecks->status_code = $statusCode;
        $urlChecks->save();

        return redirect()
        ->route('urls.show', ['url' => $id])
        ->with('success', 'Страница успешно проверена');
    }
}
