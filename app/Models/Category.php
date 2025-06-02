<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'parent_cat_id',
        'title',
        'image',
        'status',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_cat_id')->select('id', 'title');
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_cat_id')->where('status', 1)->orderBy('title')->select(['id', 'title','parent_cat_id']);
    }
    
}
