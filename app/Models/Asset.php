<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'category_id',
        'title',
        'code',
        'description',

        'purchase_date',
        'purchase_value',
        'warranty_time',
        'asset_life',
        'depreciation_rate',

        'is_assigned',
        'is_okay',
        'location',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
