<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'description',
        'deadline', // ✨ Add new field
        'duration_minutes',
        'pass_percentage',
        'is_published',
    ];

    protected $casts = [
        'deadline' => 'datetime', // ✨ Cast deadline to a Carbon instance
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(NewQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class);
    }
}