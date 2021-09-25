<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urls extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function checks()
    {
        return $this->hasMany('App\Models\UrlChecks', 'url_id');
    }
}
