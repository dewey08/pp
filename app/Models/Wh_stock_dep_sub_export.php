<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Wh_stock_dep_sub_export extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wh_stock_dep_sub_export';
    protected $primaryKey = 'wh_stock_dep_sub_export_id';
    protected $fillable = [
        'wh_stock_dep_id',
        'wh_stock_export_sub_id',      
    ];

  
}
