<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyServiceForm extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'applynow';
    protected $fillable = [
        'Id',
        'Name',
        'Application',
        'Application_Type',
        'Dob',
        'Relative_Name',
        'Mobile_No',
        'Status',
        'Reason',
        'Profile_Image',
        'Branch_Id',
        'Emp_Id'
    ];
    // protected $connection ='mysql';
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }

}
