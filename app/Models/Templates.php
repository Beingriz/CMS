<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    use HasFactory;
    protected $fillable = ['template_name', 'template_body', 'media_url', 'status'];
    // public $table = 'templates';

}
