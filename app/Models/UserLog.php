<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'users_log';
    protected $fillable = [
        'id', 'user_id', 'log_type',
        'login_at', 'logout_at', 'auto_logout_yn'
    ];
    
    public $timestamps = false;

    
}
