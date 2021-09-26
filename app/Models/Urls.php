<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Urls extends Model
{
    use HasFactory;

    //protected $fillable = ['name'];

    //public function urlChecks(): \App\Models\Urls
    //{
    //    return $this->hasMany('App\Models\UrlChecks', 'url_id');
    //}

    public function statusCode(int $id): int | null
    {
        $result = DB::table('url_checks')
        ->where('url_id', $id)
        ->orderBy('updated_at', 'desc')
        ->limit(1)
        ->first();
        return $result->status_code ?? null;
    }
}
