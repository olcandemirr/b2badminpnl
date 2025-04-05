<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'dealer_id',
        'sender_id',
        'receiver_id',
        'subject',
        'description',
        'status',
        'resolution',
        'resolved_at',
        'resolved_by',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'resolved_at' => 'datetime'
    ];

    // İlişkiler
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
    
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
