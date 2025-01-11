<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunLevel2 extends Model
{
    use HasFactory;
    protected $table = 'akun_level_2';

    public function akun3()
    {
        return $this->hasMany(AkunLevel3::class, 'parent_id', 'id')->orderBy('kode_akun', 'ASC');
    }
    public function accounts()
    {
        return $this->hasMany(Account::class, ['lev1', 'lev2'], ['lev1', 'lev2']);
    }
}
