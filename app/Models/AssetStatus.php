<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStatus extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'branch_id',
        'asset_id',
        'remarks',
        'is_okay',
        'date',
        'created_by_id',
    ];
}
