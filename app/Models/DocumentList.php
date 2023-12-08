<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentList extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'document_list';
    public $timestamp = false;
}
