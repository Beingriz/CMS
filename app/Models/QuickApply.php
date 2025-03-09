<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickApply extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    // Specify the table name if different from Laravel's convention
    protected $table = 'quick_apply';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Disable auto-increment if 'id' is not an integer
    public $incrementing = false;

    // Define the data type of the primary key
    protected $keyType = 'string';

    // Enable timestamps if they are automatically managed
    public $timestamps = true;

    // Define fillable fields for mass assignment
    protected $fillable = [
        'id',
        'client_id',
        'branch_id',
        'application',
        'application_type',
        'name',
        'mobile_no',
        'relative_name',
        'dob',
        'additional_message',
        'file',
        'user_consent',
        'status',
        'profile_image',
        'created_at',
        'updated_at',
    ];

    // Define default values
    protected $attributes = [
        'additional_message' => 'No Message',
        'file' => 'not available',
        'user_consent' => 'Not Required',
        'status' => 'Received',
        'profile_image' => 'account.png',
    ];

    // Cast attributes to correct data types
    protected $casts = [
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // protected $connection ='mysql';
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }
}
