<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_no',
        'dealer_type',
        'username',
        'password',
        'email',
        'program_code',
        'is_active',
        'first_name',
        'last_name',
        'company_title',
        'country',
        'city',
        'district',
        'postal_code',
        'address_title',
        'address',
        'address_description',
        'phone',
        'tax_office',
        'tax_number',
        'tax_document',
        'signature_circular',
        'trade_registry',
        'findeks_report',
        'has_debt_order_block',
        'has_free_payment',
        'cash_only',
        'card_payment',
        'check_payment',
        'cash_payment',
        'pay_at_door',
        'include_vat',
        'campaign_news',
        'contract',
        'kvkk',
        'separate_warehouse',
        'gift_passive',
        'tax_document_required',
        'signature_circular_required',
        'trade_registry_required',
        'findeks_report_required',
        'main_dealer',
        'balance',
        'order_limit',
        'yearly_target',
        'representative',
        'language',
        'currency',
        'price_type',
        'general_discount',
        'additional_discount',
        'extra_discount',
        'discount_profile',
        'is_super_dealer',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_debt_order_block' => 'boolean',
        'has_free_payment' => 'boolean',
        'cash_only' => 'boolean',
        'card_payment' => 'boolean',
        'check_payment' => 'boolean',
        'cash_payment' => 'boolean',
        'pay_at_door' => 'boolean',
        'include_vat' => 'boolean',
        'campaign_news' => 'boolean',
        'contract' => 'boolean',
        'kvkk' => 'boolean',
        'separate_warehouse' => 'boolean',
        'gift_passive' => 'boolean',
        'tax_document_required' => 'boolean',
        'signature_circular_required' => 'boolean',
        'trade_registry_required' => 'boolean',
        'findeks_report_required' => 'boolean',
        'is_super_dealer' => 'boolean',
    ];
} 