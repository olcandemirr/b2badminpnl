<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_no',
        'company_title',
        'dealer_type',
        'main_dealer',
        'basket',
        'login',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
} 