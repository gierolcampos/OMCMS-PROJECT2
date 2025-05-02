<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'non_ics_member_id',
        'email',
        'course_year_section',
        'is_non_ics_member',
        'method',
        'total_price',
        'purpose',
        'gcash_name',
        'gcash_num',
        'reference_number',
        'gcash_proof_path',
        'placed_on',
        'payment_status',
        'officer_in_charge',
        'receipt_control_number',
        'cash_proof_path',
        'description'
    ];

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the non-ICS member that placed the order.
     */
    public function nonIcsMember()
    {
        return $this->belongsTo(NonIcsMember::class, 'non_ics_member_id', 'id');
    }

    /**
     * Get the payer name (either ICS member or non-ICS member).
     */
    public function getPayerNameAttribute()
    {
        if ($this->is_non_ics_member && $this->nonIcsMember) {
            return $this->nonIcsMember->fullname;
        } elseif ($this->user) {
            return $this->user->firstname . ' ' . $this->user->lastname;
        }

        return 'Unknown';
    }

    /**
     * Get masked name for GCASH receipts.
     */
    public function getMaskedNameAttribute()
    {
        $gcashName = $this->gcash_name;

        if (!$gcashName) {
            return '';
        }

        $maskedName = '';
        $nameParts = explode(' ', $gcashName);

        foreach ($nameParts as $part) {
            if (strlen($part) > 2) {
                $maskedPart = substr($part, 0, 1) . str_repeat('*', strlen($part) - 2) . substr($part, -1);
            } else {
                $maskedPart = $part;
            }
            $maskedName .= $maskedPart . ' ';
        }

        return trim($maskedName);
    }
}