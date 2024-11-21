<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalUser extends Model
{
    /** @use HasFactory<\Database\Factories\PortalUserFactory> */
    use HasFactory;
    protected $table = 'portal_user';
    protected $primaryKey = 'User_Id';

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
