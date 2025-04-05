<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'type',
        'title',
        'eng',
        'description',
        'eng_description',
        'photo',
        'link',
        'order'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->photo) {
            return asset('uploads/contents/' . $this->photo);
        }
        return null;
    }

    public function getContentTypeAttribute()
    {
        $types = [
            'haber' => 'Haber',
            'duyuru' => 'Duyuru',
            'blog' => 'Blog',
            'sayfa' => 'Sayfa',
            'banner' => 'Banner'
        ];
        
        return $types[$this->type] ?? $this->type;
    }
}
