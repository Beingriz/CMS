<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMedia extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'status_media';

    // Specify the primary key if it's not 'id' or auto-increment
    protected $primaryKey = 'id';

    // Disable auto-incrementing if the primary key is a string
    public $incrementing = false;

    // Define the primary key type
    protected $keyType = 'string';

    // Specify the fillable fields for mass assignment
    protected $fillable = [
        'id',
        'service',
        'service_type',
        'status',
        'media',
    ];
}
