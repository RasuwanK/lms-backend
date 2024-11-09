<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_name',
        'credit_value',
        'practical_exam_count',
        'writing_exam_count',
        'course_id'
    ];

    // Define the relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Define the relationship with User (many-to-many if needed)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_modules', 'module_id', 'user_id')
            ->withTimestamps();
    }
}
