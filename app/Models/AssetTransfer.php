<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransfer extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'from_branch_id',
        'to_branch_id',
        'asset_id',
        'status',
        'date',
        'created_by_id',
        'updated_by_id',
    ];
}
