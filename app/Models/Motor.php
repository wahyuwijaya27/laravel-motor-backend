<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'year',
        'price',
        'image',
        'specification',
        'status',
        'is_recommended'
    ];
}
