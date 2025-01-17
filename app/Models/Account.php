<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function amount()
    {
        return $this->hasMany(Amount::class, 'account_id');
    }

    public function trx_debit()
    {
        return $this->hasMany(Transaction::class, 'rekening_debit', 'id');
    }

    public function trx_kredit()
    {
        return $this->hasMany(Transaction::class, 'rekening_kredit', 'id');
    }

    public function saldo()
    {
        return $this->hasOne(Amount::class, 'id', 'kode_akun');
    }
}
