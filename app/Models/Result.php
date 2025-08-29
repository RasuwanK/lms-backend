<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'module_id', 'result'];

    // Relationship with PortalUser
    public function user()
    {
        return $this->belongsTo(PortalUser::class, 'user_id');  // A result belongs to a user
    }

    // Relationship with Module
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');  // A result belongs to a module
    }
}
