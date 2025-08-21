<?php

namespace App\Models;

use App\Traits\HasReferentialIntegrity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes, HasReferentialIntegrity;

    protected $fillable = [
        'name',
        'code',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the states for the country.
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * Get all cities through states for the country.
     */
    public function cities()
    {
        return $this->hasManyThrough(City::class, State::class);
    }

    /**
     * Define relationships to check for referential integrity
     */
    protected function getReferentialIntegrityRelationships(): array
    {
        return ['states']; // Only check direct relationships
    }

    /**
     * Check if country has any related states
     */
    public function hasStates()
    {
        return $this->states()->exists();
    }

    /**
     * Check if country has any related cities through states
     */
    public function hasCities()
    {
        return $this->cities()->exists();
    }

    /**
     * Custom cascade delete implementation
     */
    public function cascadeDelete(): array
    {
        $deletedCounts = [];
        
        // Get counts before deletion
        $citiesCount = $this->cities()->count();
        $statesCount = $this->states()->count();
        
        // Delete all cities in all states of this country
        if ($citiesCount > 0) {
            $this->cities()->delete();
            $deletedCounts['cities'] = $citiesCount;
        }
        
        // Delete all states of this country
        if ($statesCount > 0) {
            $this->states()->delete();
            $deletedCounts['states'] = $statesCount;
        }
        
        // Delete the country
        $this->delete();
        
        return [
            'success' => true,
            'message' => 'Country and all related data deleted successfully.',
            'deleted_related' => $deletedCounts
        ];
    }
}