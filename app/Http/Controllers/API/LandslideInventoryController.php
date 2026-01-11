<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandslideInventory;
use App\Models\LandslideInventoryCandidate;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LandslideInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

   /**
     * Store a newly created landslide inventory in storage.
     *
     * This method handles the creation of a new landslide inventory record along with
     * its associated candidate locations. It validates the incoming request data,
     * processes nested JSON fields (details, analysis, remarks), and creates
     * related candidate records based on the analysis data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $user = $request->user();

        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'date' => 'required|date',
                'location' => 'nullable|string|max:255',
                'details' => 'nullable|array',
                'analysis' => 'nullable|array',
                'remarks' => 'nullable|array',
                'validation_id' => 'nullable|integer|exists:landslide_inventory_validations,id',
            ]);

            // Ensure JSON fields are objects/arrays, not null
            $details = !empty($validatedData['details']) ? $validatedData['details'] : [];
            $analysis = !empty($validatedData['analysis']) ? $validatedData['analysis'] : [];
            $remarks = !empty($validatedData['remarks']) ? $validatedData['remarks'] : [];

            // Create landslide inventory record
            $landslideInventory = LandslideInventory::create([
                'date' => $validatedData['date'],
                'location' => $validatedData['location'] ?? null,
                'details' => $details,
                'analysis' => $analysis,
                'remarks' => $remarks,
                'created_by_id' => $user ? $user->id : null,
            ]);

            // Extract best date from details or use main date as fallback
            $bestDate = isset($details['best_date']) ? $details['best_date'] : $validatedData['date'];
            
            // Extract candidates from analysis
            $candidates = isset($analysis['candidates']) && is_array($analysis['candidates']) 
                ? $analysis['candidates'] 
                : [];

            // Create candidate records for each analyzed location
            foreach ($candidates as $candidate) {
                // Skip if candidate data is incomplete
                if (!isset($candidate['id'], $candidate['centroid'], $candidate['area_m2'])) {
                    continue;
                }

                LandslideInventoryCandidate::create([
                    'landslide_inventory_id' => $landslideInventory->id,
                    'candidate_id' => $candidate['id'],
                    'date' => $bestDate,
                    'latitude' => $candidate['centroid']['lat'] ?? null,
                    'longitude' => $candidate['centroid']['lon'] ?? null,
                    'area_m2' => $candidate['area_m2'],
                    'validator_id' => $user ? $user->id : null,
                    'validation_id' => $validatedData['validation_id'] ?? 1
                ]);
            }

            // Return success response with created resource
            return response()->json([
                'success' => true,
                'message' => 'Landslide inventory created successfully',
                'data' => $landslideInventory->fresh()->load('candidates'),
            ], 201);

        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Error creating landslide inventory: ' . $e->getMessage(), [
                'user_id' => $user ? $user->id : null,
                'trace' => $e->getTraceAsString(),
            ]);

            // Return generic error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the landslide inventory',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
