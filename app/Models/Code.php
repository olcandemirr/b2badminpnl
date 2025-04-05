<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'type',
        'description',
        'is_active',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_count',
        'min_order_amount',
        'discount_type',
        'discount_amount',
        'category_id',
        'product_id',
        'dealer_id',
        'city',
        'region',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'min_order_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];
    
    // İlişkiler
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
    
    // Kod aktif mi kontrolü 
    public function isValid()
    {
        // Aktif değilse
        if (!$this->is_active) {
            return false;
        }
        
        $today = now()->startOfDay();
        
        // Başlangıç tarihi kontrolü
        if ($this->start_date && $today->lt($this->start_date)) {
            return false;
        }
        
        // Bitiş tarihi kontrolü
        if ($this->end_date && $today->gt($this->end_date)) {
            return false;
        }
        
        // Kullanım limiti kontrolü
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }
        
        return true;
    }
}
