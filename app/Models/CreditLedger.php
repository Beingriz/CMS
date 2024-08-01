<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLedger extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    public $table = "credit_ledger";
    // Add 'Id' to the fillable array to allow mass assignment
    protected $fillable = [
        'Id',
        'Client_Id',
        'Branch_Id',
        'Emp_Id',
        'Category',
        'Sub_Category',
        'Date',
        'Total_Amount',
        'Amount_Paid',
        'Balance',
        'Description',
        'Payment_Mode',
        'Attachment',
    ];

    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function ($query) use ($key) {
            $query->where('Category', 'Like', $key)->orWhere('Sub_Category', 'Like', $key)
                ->orWhere('Amount_Paid', 'Like', $key);
        });
    }
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }

}
