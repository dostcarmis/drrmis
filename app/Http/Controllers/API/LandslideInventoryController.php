<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandslideInventory;
use App\Models\User;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user();

        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
                'location' => 'nullable|string|max:255',
                'details' => 'nullable',
                'analysis' => 'nullable',
                'remarks' => 'nullable',
                'validation_status' => 'nullable|integer|exists:landslide_inventory_validations,id',
            ]);

            $landslideInventory = LandslideInventory::create(array_merge($validatedData, [
                'details' => $validatedData['details'] ?: (object)[],
                'analysis' => $validatedData['analysis'] ?: (object)[],
                'remarks' => $validatedData['remarks'] ?: (object)[],
                'validation_status' => $validatedData['validation_status'] ?? 1,
                'created_by' => $user->id ?? NULL,
            ]));

            return response()->json([
                'data' => $landslideInventory,
                'message' => 'Landslide inventory stored successfully'
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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
