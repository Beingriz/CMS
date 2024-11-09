<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;

    // Define fillable fields based on the schema
    protected $fillable = [
        'template_sid',
        'template_name',
        'lang',
        'category',
        'content_type',
        'variables',
        'body',
        'media_url',
        'status',
        'use_count',
        'last_created_at',
        'last_updated_at',
    ];

    // Casting for non-scalar attributes
    protected $casts = [
        'variables' => 'array',  // Cast JSON field to an array
    ];
}
