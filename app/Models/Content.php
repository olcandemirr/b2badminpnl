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
}
