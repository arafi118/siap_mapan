<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $guarded = ['id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
        public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan','id');
    }
}
