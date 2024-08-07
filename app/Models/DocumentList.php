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
    protected $fillable = [
        'Name'
    ];


    public function subservices()
    {
        return $this->belongsTo(SubServices::class, 'Sub_Service_Id', 'Service_Id');
    }
    public function mainservices()
    {
        return $this->belongsTo(MainServices::class, 'Service_Id', 'Id');
    }
}
