<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class AgencyController extends Controller
{
    /**
     * Approve or reject an agency request
     */
    public function approveAgencyRequest(Request $request)
    {
        try {
            $requestId = $request->input('request_id');
            $action = $request->input('action'); // 'approve' or 'reject'
            
            if (!$requestId || !in_array($action, ['approve', 'reject'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request data'
                ], 400);
            }

            // Start database transaction
            DB::beginTransaction();

            // Get the agency request data
            $agencyRequest = DB::table('agency_requests')
                ->where('id', $requestId)
                ->first();

            if (!$agencyRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Agency request not found'
                ], 404);
            }

            if ($action === 'approve') {
                // Insert data into agencies table
                $agencyData = [
                    'company_name' => $agencyRequest->company_name,
                    'email' => $agencyRequest->email,
                    'phone' => $agencyRequest->phone,
                    'contact_person_name' => $agencyRequest->contact_person_name,
                    'address' => $agencyRequest->address,
                    'pin' => $agencyRequest->pin,
                    'city' => $agencyRequest->city,
                    'state_province' => $agencyRequest->state_province,
                    'country' => $agencyRequest->country,
                    'type_of_services' => $agencyRequest->type_of_services,
                    'logo_photo' => $agencyRequest->logo_photo,
                    'brief_description' => $agencyRequest->brief_description,
                    'attachment_license' => $agencyRequest->attachment_license,
                    'status' => 'active', // Set as active when approved
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $agencyId = DB::table('agencies')->insertGetId($agencyData);

                // Update the agency request status to approved
                DB::table('agency_requests')
                    ->where('id', $requestId)
                    ->update([
                        'status' => 'approved',
                        'updated_at' => now()
                    ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Agency request approved successfully',
                    'agency_id' => $agencyId
                ]);

            } else if ($action === 'reject') {
                // Update the agency request status to rejected
                DB::table('agency_requests')
                    ->where('id', $requestId)
                    ->update([
                        'status' => 'rejected',
                        'updated_at' => now()
                    ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Agency request rejected successfully'
                ]);
            }

        } catch (Exception $e) {
            DB::rollback();
            Log::error('Error in agency approval: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request'
            ], 500);
        }
    }

    /**
     * Get agency request details for modal view
     */
    public function viewAgencyRequest($id)
    {
        try {
            $agencyRequest = DB::table('agency_requests')
                ->where('id', $id)
                ->first();

            if (!$agencyRequest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Agency request not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $agencyRequest
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching agency request: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the request'
            ], 500);
        }
    }

    /**
     * Get all agency requests for admin index
     */
    public function getAgencyRequests()
    {
        try {
            $requests = DB::table('agency_requests')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $requests
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching agency requests: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching requests'
            ], 500);
        }
    }
}