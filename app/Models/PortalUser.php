<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PortalUser extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\PortalUserFactory> */
    use HasFactory,HasApiTokens,Notifiable;
    protected $table = 'portal_users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Full_Name',
        'Age',
        'Email',
        'Mobile_No',
        'Address',
        'Institution',
        'Password',
        'Role',
        'Status',
        'Course_Id',
        'Profile_Picture'
    ];
}
