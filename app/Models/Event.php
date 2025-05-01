<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_type',
        'start_date_time',
        'end_date_time',
        'location',
        'location_details',
        'status',
        'notes',
        'created_by',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Determine if the event is upcoming.
     *
     * @return bool
     */
    public function isUpcoming(): bool
    {
        return $this->status === 'upcoming';
    }
    
    /**
     * Determine if the event is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
    
    /**
     * Determine if the event is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
    
    /**
     * Get the attendances for the event.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }
    
    /**
     * Get the attending users for the event.
     */
    public function attendingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_attendances')
            ->withPivot('status', 'comment')
            ->withTimestamps();
    }
}
