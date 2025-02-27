<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Operate_time_dss extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'operate_time_dss';
    protected $primaryKey = 'operate_time_dss_id';
    protected $fillable = [
        'operate_time_dss_date',
        'operate_time_dss_personid',
        'operate_time_dss_typeid',
        'operate_time_dss_person',
        'operate_time_dss_in',
        'operate_time_dss_out',
        'operate_time_dss_otin',
        'operate_time_dss_otout',
        'totaltime_narmal',
        'totaltime_ot'
    ];


}
