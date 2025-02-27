<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_temp203 extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_temp203';
    protected $primaryKey = 'acc_temp203_id';
    protected $fillable = [
        'vstdate',
        'vn',
        'hn'
    ];


}
