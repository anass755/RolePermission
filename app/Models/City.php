<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'stateid',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stateid' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Get the state that owns the city.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'stateid');
    }

    /**
     * Get the country through state relationship.
     */
    public function country()
    {
        return $this->hasOneThrough(Country::class, State::class, 'id', 'id', 'stateid', 'countryid');
    }

    /**
     * Scope a query to only include active cities.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive cities.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include cities of active states.
     */
    public function scopeWithActiveState($query)
    {
        return $query->whereHas('state', function ($query) {
            $query->where('status', 1);
        });
    }

    /**
     * Scope a query to only include cities of active countries.
     */
    public function scopeWithActiveCountry($query)
    {
        return $query->whereHas('state.country', function ($query) {
            $query->where('status', 1);
        });
    }

    /**
     * Check if the city is active.
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }

    /**
     * Check if the city is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === 0;
    }
}