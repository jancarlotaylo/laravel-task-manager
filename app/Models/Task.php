<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    // Fillable attributes define which columns can be mass-assigned
    protected $fillable = [
        'title',         // Title of the task
        'content',       // Content or description of the task
        'status',        // The status of the task (e.g., completed, pending)
        'user_id',       // The user that the task is assigned to
        'published_at',  // Timestamp for when the task was published
    ];

    // Casting attributes to specific data types or classes
    protected $casts = [
        'status' => TaskStatus::class,  // Cast status as TaskStatus Enum
        'published_at' => 'datetime',   // Cast published_at as a datetime instance
    ];

    /**
     * Define a relationship where each task belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include tasks assigned to the logged-in user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAssignedToUser($query, $userId = null): Builder
    {
        // Default to the authenticated user if no user ID is passed
        $userId = $userId ?? auth()->id();

        return $query->where('user_id', $userId);
    }

    /**
     * Get the publication status of the task.
     *
     * @return string The publication status of the task ('published' or 'draft')
     */
    public function getPublicationAttribute(): string
    {
        // Check if published_at is not null and return the appropriate state
        return $this->published_at ? 'published' : 'draft';
    }
}
