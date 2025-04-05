<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'eng',
        'description',
        'eng_description',
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
    
    public function products()
    {
        return $this->hasMany(Product::class, 'discount_group_code', 'name');
    }
}
