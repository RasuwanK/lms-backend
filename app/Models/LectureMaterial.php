<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureMaterial extends Model
{
    use HasFactory;

    protected $table = 'lecture_materials';
    protected $primaryKey = 'id';

    protected $fillable = [
        'material_type',
        'material_title',
        'material_url'
    ];

    public function topic(){
        $this->belongsTo(Topic::class);
    }
}
