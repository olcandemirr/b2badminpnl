<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'is_sent_as_email',
        'is_read'
    ];

    protected $casts = [
        'is_sent_as_email' => 'boolean',
        'is_read' => 'boolean'
    ];

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
} 