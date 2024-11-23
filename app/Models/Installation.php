<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
            return $this->belongsTo(Customer::class, 'id', 'id');
    }
    public function hamlet()
    {
            return $this->belongsTo(Hamlet::class, 'dusun', 'id');
    }
    public function package()
    {
            return $this->belongsTo(Package::class, 'id', 'id');
    }

}
