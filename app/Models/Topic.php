<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'type',
        'is_visible',
        'is_complete'
    ];

    protected $table = 'topics';
    public function course()
    {
        $this->belongsTo(Course::class);
    }

    public function module()
    {
        $this->belongsTo(Module::class);
    }

    public function lectureMaterials(){
        return $this->hasMany(LectureMaterial::class);
    }

}
