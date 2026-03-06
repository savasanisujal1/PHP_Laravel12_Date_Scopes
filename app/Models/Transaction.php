<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaracraftTech\LaravelDateScopes\DateScopes;

class Transaction extends Model
{
    use HasFactory, DateScopes;

    protected $fillable = ['title', 'amount'];
}