<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequisition extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'tr_no',
        'by_branch_id',
        'from_branch_id',
        'to_branch_id',
        'date',
        'creator_branch_remarks',
        'receiver_branch_remarks',
        'created_by_id',
        'updated_by_id',
        'from_branch_created_by_id',
        'from_branch_updated_by_id',
        'status',
    ];

    public function trdetails()
    {
        return $this->hasMany(RequisitionDetails::class, 'requisition_id');
    }
}
