<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Course extends Model
{
    use HasFactory,HasApiTokens;
    protected $primaryKey = 'id';
    protected $table = 'courses';

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
//    public function module()
//    {
//        return $this->hasMany(Module::class);
//    }

    // Define the relationship with User (many-to-many)
    public function users()
    {
        return $this->belongsToMany(PortalUser::class, 'enrollments', 'course_id', 'user_id')->withTimestamps();
    }
    public function portalUsers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PortalUser::class, 'course_id', 'id'); // Foreign key is 'course_id' in portal_users, primary key is 'id' in courses
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'course_module');
    }

}
