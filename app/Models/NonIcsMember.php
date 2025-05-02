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
        'fullname',
        'student_id',
        'course_year_section',
        'mobile_no',
        'method',
        'total_price',
        'purpose',
        'description',
        'payment_status',
        'placed_on',
        'officer_in_charge',
        'receipt_control_number',
        'cash_proof_path',
        'gcash_name',
        'gcash_num',
        'reference_number',
        'gcash_proof_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'placed_on' => 'datetime',
        'total_price' => 'decimal:2',
        'payment_status' => 'string',
        'method' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'placed_on',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the orders associated with the non-ICS member.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'non_ics_member_id', 'id');
    }
}
