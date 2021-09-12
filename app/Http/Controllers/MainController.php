<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urls;
use App\Http\Requests\UrlRequest;

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

    public function home()
    {
        return view('home');
    }

    public function urls()
    {
        $urls = new Urls();
        return view('urls', ['urls' => $urls->all()]);
    }

    public function urlShow($id)
    {
        $url = new Urls();
        return view('urlShow', ['url' => $url->find($id)]);
    }
}
