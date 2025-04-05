<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'eng',
        'description',
        'eng_description',
        'description1',
        'eng_description1',
        'photo',
        'link',
        'style',
        'order'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->photo) {
            return asset('uploads/slides/' . $this->photo);
        }
        return null;
    }

    public function getStyleClassAttribute()
    {
        return $this->style ? 'slide-style-'.$this->style : '';
    }
}
