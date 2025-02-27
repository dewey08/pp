<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Wh_product_sub extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wh_product_sub';
    protected $primaryKey = 'wh_product_sub_id';
    protected $fillable = [
        'pro_id',
        'pro_color',
        'pro_brand'
    ];


}
