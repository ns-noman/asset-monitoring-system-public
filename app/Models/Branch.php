<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'title',
        'code',
        'phone',
        'address',
        'is_main_branch',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
