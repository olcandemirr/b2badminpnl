<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'option',
        'option_en',
        'votes',
        'order',
        'is_active'
    ];

    protected $casts = [
        'votes' => 'integer',
        'order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Oy sayısını artır
     * 
     * @return void
     */
    public function incrementVotes()
    {
        $this->increment('votes');
    }

    /**
     * Aktif seçenekleri getir
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}
