<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'type',
        'category',
        'brand',
        'product_code',
        'name',
        'name_en',
        'unit',
        'vat_rate',
        'box_content',
        'order',
        'desi',
        'points',
        'barcode',
        'price1',
        'price2',
        'price3',
        'price4',
        'price5',
        'currency1',
        'currency2',
        'currency3',
        'currency4',
        'currency5',
        'discounted_price',
        'discounted_currency',
        'cost',
        'discount_rate',
        'additional_discount',
        'discount_group_code',
        'min_order',
        'increment',
        'max_order',
        'warehouse1_stock',
        'warehouse2_stock',
        'warehouse3_stock',
        'photo',
        'description',
        'description_en',
        'search_tags',
        'counter_date',
        'discount_stock_date',
        'is_passive',
        'is_closed',
        'is_out_of_stock',
        'is_showcase',
        'is_bestseller',
        'is_campaign',
        'has_gift',
        'is_new',
        'has_counter',
        'has_discount_stock',
    ];

    protected $casts = [
        'is_passive' => 'boolean',
        'is_closed' => 'boolean',
        'is_out_of_stock' => 'boolean',
        'is_showcase' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_campaign' => 'boolean',
        'has_gift' => 'boolean',
        'is_new' => 'boolean',
        'has_counter' => 'boolean',
        'has_discount_stock' => 'boolean',
        'counter_date' => 'datetime',
        'discount_stock_date' => 'datetime',
        'price1' => 'decimal:2',
        'price2' => 'decimal:2',
        'price3' => 'decimal:2',
        'price4' => 'decimal:2',
        'price5' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'additional_discount' => 'decimal:2',
        'min_order' => 'integer',
        'increment' => 'integer',
        'max_order' => 'integer',
        'warehouse1_stock' => 'integer',
        'warehouse2_stock' => 'integer',
        'warehouse3_stock' => 'integer',
        'order' => 'integer',
        'desi' => 'decimal:2',
        'points' => 'integer',
    ];

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price1, 2, ',', '.') . ' ₺';
    }

    public function getFormattedDealerPriceAttribute()
    {
        return number_format($this->price1, 2, ',', '.') . ' ₺';
    }
}
