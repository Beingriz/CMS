<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = 'digital_cyber_db';
    protected $primaryKey = 'Id';
    public $incrementing = false; // since the primary key is a string

    protected $connection = 'mysql';

    protected $guarded;
    public function scopeFilter($query, $key)
    {
        $key = "%$key%";
        $query->where(function ($query) use ($key) {
            $query->where('Name', 'Like', $key)
                ->orWhere('Amount_Paid', 'Like', $key)
                ->orWhere('Application', 'Like', $key)
                ->orWhere('Ack_No', 'Like', $key)
                ->orWhere('Document_No', 'Like', $key)
                ->orWhere('Received_Date', 'Like', $key)
                ->orWhere('Status', 'Like', $key)
                ->orWhere('Mobile_No', 'Like', $key)
                ->orWhere('Application_Type', 'Like', $key);
        });
    }
    // In app/Models/DigitalCyberDb.php
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }

    //defining relation
    public function client()
    {
        return $this->belongsTo(ClientRegister::class, 'Client_Id', 'Id');
    }

    public function mainServices()
    {
        return $this->belongsTo(MainServices::class);
    }
}
