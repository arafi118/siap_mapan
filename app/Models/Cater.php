<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cater extends Model
{
    use HasFactory;
    public function position()
    {
        return $this->belongsTo(Position::class, 'jabatan', 'id');
    }
}
