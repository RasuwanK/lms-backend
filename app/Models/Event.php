<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Event extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'userid',
        'title',
        'description',
        'event_date',
    ];
}
