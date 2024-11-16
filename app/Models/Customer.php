<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function keluarga()
    {
            return $this->belongsTo(Family::class, 'hubungan', 'id');
    }
        
    public function d()
    {
            return $this->belongsTo(Village::class, 'nama', 'kode');
    }

    public function getRouteKeyName()
    {
        return 'nik';
    }
}
