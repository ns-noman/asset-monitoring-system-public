<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionDetails extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'requisition_id',
        'category_id',
        'quantity',
    ];
}
