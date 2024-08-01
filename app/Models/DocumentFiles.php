<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFiles extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    public $table = 'document_files';
    protected $fillable = [
        'Id',
        'App_Id',
        'Client_Id',
        'Document_Name',
        'Document_Path',
        'Branch_Id',
        'Emp_Id'
    ];
}
