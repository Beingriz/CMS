<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debit extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = "debit_ledger";
    // public $timestamps=false;

    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function ($query) use ($key) {
            $query->where('Source', 'Like', $key)->orWhere('Name', 'Like', $key)
                ->orWhere('Amount_Paid', 'Like', $key);
        });
    }
}
