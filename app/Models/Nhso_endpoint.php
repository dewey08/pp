<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Nhso_endpoint extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql10';
    protected $table = 'nhso_endpoint';
    protected $primaryKey = 'nhso_endpoint_id';
    protected $fillable = [
        'vn',
        'claimcode'
    ];
    public $timestamps = false;
}
