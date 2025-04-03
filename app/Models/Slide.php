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
        'order',
        'style'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
