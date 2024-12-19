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
     * BelongsTo => Tabel relasi punya banyak installasi
     * HasMany => Tabel installasi punya banyak relasi
     */

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
        return $this->hasOne(Usage::class, 'installation_id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'installation_id');
    }
}
