<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditSources extends Model
{
    use HasFactory;
    public $table="credit_sources";
    public $timestamp =  false;

    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function($query) use ($key)
        {
            $query->where('Source','Like',$key)->orWhere('Total_Revenue','Like',$key);
        });
    }
}
