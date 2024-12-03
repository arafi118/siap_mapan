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

    public function installation()
    {
    return $this->hasMany(Installations::class);
    }
        
    public function village()
    {
            return $this->belongsTo(Village::class, 'desa', 'kode');
    }

    public function getRouteKeyName()
    {
        return 'nik';
    }
}
