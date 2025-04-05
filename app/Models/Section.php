<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'eng', 'order'];
    
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    
    public function slides()
    {
        return $this->hasMany(Slide::class);
    }
    
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
