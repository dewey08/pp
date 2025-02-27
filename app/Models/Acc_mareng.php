<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_mareng extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_mareng';
    protected $primaryKey = 'acc_mareng_id';
    protected $fillable = [
        'vn',
        'hn',
        'vstdate'         
    ];

  
}
