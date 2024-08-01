<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'feedback';
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }

}
