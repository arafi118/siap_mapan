<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

          
    public function installation()
    {
            return $this->belongsTo(Installations::class, 'kode_instalasi','kode_instalasi');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }
}
