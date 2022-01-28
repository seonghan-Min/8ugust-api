<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $fillable = [
        'name', 'email', 'password',
    ];
}