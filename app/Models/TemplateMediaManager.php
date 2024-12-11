<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMediaManager extends Model
{
    use HasFactory;

    protected $table = 'template_media_manager';

    protected $keyType = 'string'; // Indicate the primary key is a string
    public $incrementing = false; // Disable auto-incrementing

    protected $fillable = [
        'id',
        'sid',
        'template_name',
        'body',
        'media_file',
    ];
}
