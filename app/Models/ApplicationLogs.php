<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',                // Make the id field mass assignable
        'application_id',
        'action',
        'emp_id',
        'branch_id',
        'name',
        'gender',
        'relative_name',
        'dob',
        'mobile_no',
        'application',
        'application_type',
        'received_date',
        'applied_date',
        'total_amount',
        'amount_paid',
        'balance',
        'payment_mode',
        'payment_receipt',
        'status',
        'reason',
        'ack_no',
        'ack_file',
        'document_no',
        'doc_file',
        'applicant_image',
        'delivered_date',
        'message',
        'consent',
        'recycle_bin',
        'registered',
        'total_doc_uploaded',
    ];
    protected $table = 'app_transaction_logs';
}
