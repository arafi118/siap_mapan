<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunLevel3 extends Model
{
    use HasFactory;
    protected $table = 'akun_level_3';

    public function accounts()
    {
        return $this->hasMany(Account::class, 'parent_id', 'id');
    }
}