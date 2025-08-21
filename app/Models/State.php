<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'countryid',
        'name',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'countryid' => 'integer',
        'status' => 'integer',
    ];

    /**
     * Get the country that owns the state.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid');
    }

    /**
     * Get the cities for the state.
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'stateid');
    }

    /**
     * Scope a query to only include active states.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to only include inactive states.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Scope a query to only include states of active countries.
     */
    public function scopeWithActiveCountry($query)
    {
        return $query->whereHas('country', function ($query) {
            $query->where('status', 1);
        });
    }

    /**
     * Check if the state is active.
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }

    /**
     * Check if the state is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === 0;
    }
}