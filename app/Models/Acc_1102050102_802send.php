<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Acc_1102050102_802send extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'acc_1102050102_802send';
    protected $primaryKey = 'acc_1102050102_802send_id';
    protected $fillable = [
        'vn',
        'an',
        'hn'
    ];


}
