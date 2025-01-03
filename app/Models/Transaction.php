<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
    public function village()
    {
        return $this->belongsTo(Village::class, 'desa');
    }
    public function usage()
    {
        return $this->hasOne(Usage::class, 'kode_instalasi', 'id');
    }
    public function Installations()
    {
        return $this->belongsTo(Installations::class);
    }
}
