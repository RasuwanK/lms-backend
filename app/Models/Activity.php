<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_name',
        'type',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'instructions',
        'question_count',
        'module_id'
    ];
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
