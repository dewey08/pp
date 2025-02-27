<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_temp216 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_temp216';
    // protected $primaryKey = 'acc_temp216_id';
    protected $primaryKey = 'vn';
    protected $fillable = [
        'vstdate',
        'vn',
        'hn'
    ];


}
