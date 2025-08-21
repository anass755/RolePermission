<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Delete a country with referential integrity check
     */
    public function deleteCountry(Request $request, $id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
            $result = $country->safeDelete();
            
            return response()->json($result, $result['success'] ? 200 : 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Country not found or error occurred.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Force delete a country with all related data (cascade)
     */
    public function forceDeleteCountry(Request $request, $id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
            $result = $country->cascadeDelete();
            
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Country not found or error occurred.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a state with referential integrity check
     */
    public function deleteState(Request $request, $id): JsonResponse
    {
        try {
            $state = State::findOrFail($id);
            $result = $state->safeDelete();
            
            return response()->json($result, $result['success'] ? 200 : 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'State not found or error occurred.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Force delete a state with all related cities (cascade)
     */
    public function forceDeleteState(Request $request, $id): JsonResponse
    {
        try {
            $state = State::findOrFail($id);
            $result = $state->cascadeDelete();
            
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'State not found or error occurred.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Delete a city with referential integrity check
     */
    public function deleteCity(Request $request, $id): JsonResponse
    {
        try {
            $city = City::findOrFail($id);
            $result = $city->safeDelete();
            
            return response()->json($result, $result['success'] ? 200 : 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'City not found or error occurred.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get relationship counts for a country before deletion
     */
    public function getCountryRelationships($id): JsonResponse
    {
        try {
            $country = Country::findOrFail($id);
            
            return response()->json([
                'country' => $country->name,
                'states_count' => $country->states()->count(),
                'cities_count' => $country->cities()->count(),
                'can_delete' => !$country->hasStates()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Country not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get relationship counts for a state before deletion
     */
    public function getStateRelationships($id): JsonResponse
    {
        try {
            $state = State::findOrFail($id);
            
            return response()->json([
                'state' => $state->name,
                'country' => $state->country->name,
                'cities_count' => $state->cities()->count(),
                'can_delete' => !$state->hasCities()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'State not found.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Bulk delete with referential integrity checks
     */
    public function bulkDeleteCountries(Request $request): JsonResponse
    {
        $request->validate([
            'country_ids' => 'required|array',
            'country_ids.*' => 'integer|exists:countries,id',
            'force' => 'boolean'
        ]);

        $results = [];
        $force = $request->get('force', false);

        foreach ($request->country_ids as $countryId) {
            try {
                $country = Country::find($countryId);
                if ($country) {
                    $result = $force ? $country->cascadeDelete() : $country->safeDelete();
                    $results[] = array_merge($result, ['country_id' => $countryId, 'country_name' => $country->name]);
                }
            } catch (\Exception $e) {
                $results[] = [
                    'success' => false,
                    'message' => 'Error deleting country.',
                    'country_id' => $countryId,
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'results' => $results,
            'total_processed' => count($results),
            'successful_deletions' => count(array_filter($results, fn($r) => $r['success']))
        ]);
    }
}