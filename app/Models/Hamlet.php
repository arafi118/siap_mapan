<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hamlet extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public $timestamps = false;
    
    public function village()
    {
        return $this->belongsTo(Village::class, 'id_desa');
    }
}
