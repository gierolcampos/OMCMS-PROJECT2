<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonIcsMember extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'alternative_email',
        'fullname',
        'student_id',
        'course_year_section',
        'department',
        'mobile_no',
        'address',
        'notes',
        'payment_status',
        'membership_type',
        'membership_expiry',
    ];

    /**
     * Get the orders associated with the non-ICS member.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'non_ics_member_id');
    }
}
