<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urls;
use App\Models\UrlChecks;
use Illuminate\Support\Facades\Http;
use DiDom\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MainController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function checks(int $id, UrlChecks $urlChecks, Urls $url): RedirectResponse
    {
        try {
            $response = Http::timeout(3)->get($url->find($id)->name);
            $document = new Document($response->body());
        } catch (\Exception $exception) {
            return redirect()
            ->route('urls.show', ['url' => $id])
            ->with('flash_message', [
                'class' => 'danger',
                'message' => $exception->getMessage()
            ]);
        }

        $urlChecks->url_id = $id;
        $urlChecks->status_code = $response->status();
        $urlChecks->h1 = optional($document->first('h1'))->text();
        $urlChecks->keywords = optional($document->first('meta[name=keywords]'))->attr('content');
        $urlChecks->description = optional($document->first('meta[name=description]'))->attr('content');
        $urlChecks->save();

        DB::table('urls')->where('id', '=', $id)->update(['updated_at' => now()]);

        return redirect()
        ->route('urls.show', ['url' => $id])
        ->with('flash_message', [
            'class' => 'info',
            'message' => 'Страница успешно проверена'
        ]);
    }
}
