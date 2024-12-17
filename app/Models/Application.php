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

    //Transaction logs
    protected static function booted()
    {
        // Log initial creation
        static::created(function ($application) {
            self::logTransaction($application, 'Created');
        });

        // Log updates
        static::updated(function ($application) {
            self::logTransaction($application, 'Updated');
        });

        // Log deletions
        static::deleted(function ($application) {
            self::logTransaction($application, 'Deleted');
        });
    }

    /**
     * Log transactions to the app_transaction_logs table.
     *
     * @param  \App\Models\Application  $application
     * @param  string  $action
     * @return void
     */
    protected static function logTransaction($application, $action)
    {
        ApplicationLogs::create([
            'id'                => uniqid(), // Unique ID for transaction log
            'application_id'    => $application->Id,
            'action'            => $action,
            'emp_id'            => $application->Emp_Id,
            'branch_id'         => $application->Branch_Id ?? null,
            'name'              => $application->Name,
            'gender'            => $application->Gender,
            'relative_name'     => $application->Relative_Name,
            'dob'               => $application->DOB,
            'mobile_no'         => $application->Mobile_No,
            'application'       => $application->Application,
            'application_type'  => $application->Application_Type,
            'received_date'     => $application->Received_Date,
            'applied_date'      => $application->Applied_Date,
            'total_amount'      => $application->Total_Amount,
            'amount_paid'       => $application->Amount_Paid,
            'balance'           => $application->Balance,
            'payment_mode'      => $application->Payment_Mode,
            'payment_receipt'   => $application->Payment_Receipt,
            'status'            => $application->Status,
            'reason'            => $application->Reason,
            'ack_no'            => $application->Ack_No,
            'ack_file'          => $application->Ack_File,
            'document_no'       => $application->Document_No,
            'doc_file'          => $application->Doc_File,
            'applicant_Image'   => $application->Applicant_Image,
            'delivered_date'    => $application->Delivered_Date,
            'message'           => $application->Message,
            'consent'           => $application->Consent,
            'recycle_Bin'       => $application->Recycle_Bin,
            'registered'        => $application->Registered,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }

}
