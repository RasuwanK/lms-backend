<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    //protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_name',
        'credit_value',
        'maximum_students',
        'department_id'
    ];

    // Define the relationship with the Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Define the relationship with Module
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    // Define the relationship with User (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->withTimestamps();
    }

}
