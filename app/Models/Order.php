<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'dealer_id',
        'status',
        'payment_method',
        'company_title',
        'dealer_type',
        'main_dealer',
        'total',
        'message',
        'customer_name'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}
