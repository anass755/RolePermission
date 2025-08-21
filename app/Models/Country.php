<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

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
}