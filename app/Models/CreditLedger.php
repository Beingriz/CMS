<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLedger extends Model
{
    use HasFactory;
    public $table="credit_ledger";
    public $timestamps=false;

    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function($query) use ($key)
        {
            $query->where('Category','Like',$key)->orWhere('Sub_Category','Like',$key)
            ->orWhere('Amount_Paid','Like',$key);
        });
    }
}
