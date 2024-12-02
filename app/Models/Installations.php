<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installations extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
            return $this->belongsTo(Customer::class);
    }
    public function package()
    {
            return $this->belongsTo(Package::class);
    }
    public function Village()
    {
            return $this->belongsTo(Village::class, 'id');
    }

}
