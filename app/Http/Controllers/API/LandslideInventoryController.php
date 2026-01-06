<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandslideInventory;
use Illuminate\Validation\ValidationException;

class LandslideInventoryController extends Controller
{
    // public function __construct()
    // {
    //     // Apply CORS headers to all responses from this controller
    //     $this->middleware(function ($request, $next) {
    //         $response = $next($request);

    //         $response->headers->set('Access-Control-Allow-Origin', ['http://localhost:3000', 'http://drrmis.test']);
    //         $response->headers->set('Access-Control-Allow-Methods', '*');
    //         $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');

    //         return $response;
    //     });
    // }

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
                'details' => json_encode($validatedData['details'] ?? []),
                'analysis' => json_encode($validatedData['analysis'] ?? []),
                'remarks' => json_encode($validatedData['remarks'] ?? []),
            ]));

            return response()->json([
                'data' => $landslideInventory,
                'message' => 'Landslide inventory stored successfully'
            ]);
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
