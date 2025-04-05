<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'rate',
        'order'
    ];
    
    protected $casts = [
        'rate' => 'decimal:2'
    ];
    
    public function getFormattedRateAttribute()
    {
        return '%' . number_format($this->rate, 2);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'discount_code', 'code');
    }
}
