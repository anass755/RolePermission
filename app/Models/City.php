<?php

namespace App\Models;

use App\Traits\HasReferentialIntegrity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes, HasReferentialIntegrity;

    protected $fillable = [
        'name',
        'code',
        'state_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the state that owns the city.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the country through state.
     */
    public function country()
    {
        return $this->hasOneThrough(Country::class, State::class, 'id', 'id', 'state_id', 'country_id');
    }

    /**
     * Define relationships to check for referential integrity
     * Add any relationships that reference this city (e.g., users, addresses, etc.)
     */
    protected function getReferentialIntegrityRelationships(): array
    {
        // Example: return ['users', 'addresses', 'offices'];
        return []; // No related models for now - extend this as needed
    }

    /**
     * Example method to add relationships that reference cities
     * Uncomment and modify as needed for your application
     */
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }
    
    // public function addresses()
    // {
    //     return $this->hasMany(Address::class);
    // }
}