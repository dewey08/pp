<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Wh_config_store extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wh_config_store';
    protected $primaryKey = 'wh_config_store_id';
    protected $fillable = [
        'stock_list_id',
        'stock_list_subid',
        'user_id'
    ];


}
