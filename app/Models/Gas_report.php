<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Gas_report extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'gas_report';
    protected $primaryKey = 'gas_report_id';
    protected $fillable = [
        'bg_yearnow',
        'months',
        'years'
    ];


}
