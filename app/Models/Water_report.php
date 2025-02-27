<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Water_report extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'water_report';
    protected $primaryKey = 'water_report_id';
    protected $fillable = [
        'bg_yearnow',       
    ];

  
}
