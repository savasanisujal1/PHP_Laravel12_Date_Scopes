<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Transaction extends Model
{
    use DateScopes;

    public $timestamps = false;

    protected $fillable = ['title', 'amount', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}