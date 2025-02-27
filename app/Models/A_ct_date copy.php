<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Facades\Http;
use Illuminate\Contracts\Auth\MustVerifyEmail; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class A_ct_date extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'a_ct_date'; 
    protected $primaryKey = 'a_ct_date_id';
    protected $fillable = [
        'startdate', 
        'enddate',  
        'user_id' 
    ];
    // public $timestamps = false; 

  
}
