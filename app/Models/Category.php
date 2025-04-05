<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'name',
        'eng',
        'file',
        'order',
        'percentage',
        'link'
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }

    public function getImageUrlAttribute()
    {
        if ($this->file) {
            return asset('uploads/categories/' . $this->file);
        }
        return null;
    }
}
