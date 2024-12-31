<?php

namespace App\Models;

use App\Utils\Tanggal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Installations extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * ===========================================================
     * BelongsTo    => Tabel relasi punya banyak installasi
     * HasMany      => Tabel installasi punya banyak relasi
     * HasOne       => Dari banyaknya data HasMany hanya akan diambil 1
     * ===========================================================
     * $this->belongsTo(Model, Pengghubung Pada Model, Kunci Pemilik)
     * ===========================================================
     * $this->hasMany(Model, Pengghubung Pada Model, Kunci Pemilik)
     * $this->hasOne(Model, Pengghubung Pada Model, Kunci Pemilik)
     * ===========================================================
     */

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
    public function village()
    {
        return $this->belongsTo(Village::class, 'desa');
    }
    public function usage()
    {
        return $this->hasMany(Usage::class, 'kode_instalasi', 'kode_instalasi');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'installation_id');
    }

    public function settings()
    {
        return $this->hasOne(Settings::class, 'business_id', 'business_id');
    }
}
