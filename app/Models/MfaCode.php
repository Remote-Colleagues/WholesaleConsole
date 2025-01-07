<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MfaCode extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'code', 'expires_at'];

    protected $dates = ['expires_at'];
}
