<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'dealer_id',
        'ip_address',
        'action', 
        'details'
    ];

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the dealer that owns the log.
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
     * Create a new log entry
     *
     * @param string $action
     * @param array|string $details
     * @return \App\Models\Log
     */
    public static function add($action, $details = null)
    {
        $userId = auth()->id();
        $dealerId = auth()->user() && auth()->user()->dealer_id ? auth()->user()->dealer_id : null;
        
        return self::create([
            'user_id' => $userId,
            'dealer_id' => $dealerId,
            'ip_address' => request()->ip(),
            'action' => $action,
            'details' => is_array($details) ? json_encode($details) : $details,
        ]);
    }
}
