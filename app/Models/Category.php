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

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
