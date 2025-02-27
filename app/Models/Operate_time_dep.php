<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operate_time_dep extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operate_time_dep';
    protected $primaryKey = 'operate_time_dep_id';
    protected $fillable = [
        'operate_time_dep_date',
        'operate_time_dep_personid',
    ];


}
