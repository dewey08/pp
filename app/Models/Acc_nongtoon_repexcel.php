<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_nongtoon_repexcel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_nongtoon_repexcel';
    protected $primaryKey = 'acc_nongtoon_repexcel_id';
    protected $fillable = [
        'vstdate',
        'hn'
    ];


}
