<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'image_url', // ✨ Add new field
        'points',
    ];

    public function quiz()
    {
        return $this->belongsTo(NewQuiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}