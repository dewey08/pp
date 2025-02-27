<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operate_time_dept extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operate_time_dept';
    protected $primaryKey = 'operate_time_dept_id';
    protected $fillable = [
        'start_date',
        'end_date',
        'depid',
        'user_id'
    ];


}
