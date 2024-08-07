<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Client_Id',
        'Emp_Id',
        'branch_id',
        'name',
        'username',
        'mobile_no',
        'dob',
        'gender',
        'role',
        'Status',
        'address',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define the relationship with the Branches model.
     */
    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id', 'branch_id');
        //branch_id - first one. is foreign key in current model
        // branch id is- second one is primary key in branches table.

    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('Branch_Id', $branchId);
    }

}
