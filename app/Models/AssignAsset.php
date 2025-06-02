<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignAsset extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'branch_id',
        'asset_id',
        'created_by_id',
        'updated_by_id',
        'date',
        'in_branch',
    ];
}
