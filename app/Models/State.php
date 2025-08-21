<?php

namespace App\Models;

use App\Traits\HasReferentialIntegrity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes, HasReferentialIntegrity;

    protected $fillable = [
        'name',
        'code',
        'country_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the country that owns the state.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the cities for the state.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Define relationships to check for referential integrity
     */
    protected function getReferentialIntegrityRelationships(): array
    {
        return ['cities'];
    }

    /**
     * Check if state has any related cities
     */
    public function hasCities()
    {
        return $this->cities()->exists();
    }
}