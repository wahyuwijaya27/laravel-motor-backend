<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'nama_lengkap', 
        'alamat_lengkap', 
        'nomor_telepon', 
        'motor_id', 
        'bukti_transaksi'
    ];

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

}
