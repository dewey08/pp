<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dapiherb_ipd extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'dapiherb_ipd';
    protected $primaryKey = 'dapiherb_ipd_id';
    protected $fillable = [
        'blobName',
        'blobType',
        'blob'         
    ];

  
}
