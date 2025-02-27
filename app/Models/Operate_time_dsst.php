<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operate_time_dsst extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operate_time_dsst';
    protected $primaryKey = 'operate_time_dsst_id';
    protected $fillable = [
        'start_date',
        'end_date',
        'depsubsubid',
        'user_id' 
    ];


}
