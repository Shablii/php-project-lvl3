<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UrlChecks extends Model
{
    use HasFactory;

    public function statusCode($id)
    {
        $result = DB::table('url_checks')
        ->where('url_id', $id)
        ->orderBy('updated_at', 'desc')
        ->limit(1)
        ->first();
        return $result->status_code ?? null;
    }
}
