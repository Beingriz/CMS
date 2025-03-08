<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $table = 'branches';

    protected $primaryKey = 'branch_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'branch_id',
        'name',
        'address',
        'google_map_link',
        'user_count',
        'employee_count'
    ];

    protected $casts = [
        'user_count' => 'integer',
        'employee_count' => 'integer'
    ];

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
