<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class D_apiwalkin_opd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'd_apiwalkin_opd';
    protected $primaryKey = 'd_apiwalkin_opd_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
