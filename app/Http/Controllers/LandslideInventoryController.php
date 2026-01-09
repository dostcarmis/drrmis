<?php

namespace App\Http\Controllers;

use App\Models\LandslideInventory;
use App\Models\LandslideInventoryValidation;
use Illuminate\Http\Request;

class LandslideInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $landslides = LandslideInventory::with(['user', 'landslideInventoryValidation'])
            ->orderBy('created_at', 'desc')->get();

        return view('pages.landslide-inventories', compact('landslides'));
    }

    public function store(Request $request)
{
    // Accept JSON payload (React)
    $payload = $request->json()->all();
    if (empty($payload)) {
        $payload = $request->all(); // fallback
    }


    // Validate required fields
    if (empty($payload['date'])) {
        return response()->json([
            'ok' => false,
            'error' => 'Date is required'
        ], 422);
    }

    $inventory = new LandslideInventory();

    $inventory->date = $payload['date'];                  // YYYY-MM-DD
    $inventory->location = $payload['location'] ?? null;

    // JSON columns (MySQL JSON type)
    $inventory->details  = $payload['details']  ?? null;
    $inventory->analysis = $payload['analysis'] ?? null;
    $inventory->remarks  = $payload['remarks']  ?? null;

    // Default validation status (1 = pending)
    $inventory->validation_status = 1;

    // Link to logged-in DRRMIS user
    if (auth()->check()) {
        $inventory->created_by = auth()->id();
    }

    $inventory->save();

    return response()->json([
        'ok' => true,
        'id' => $inventory->id,
    ], 201);
}

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $landslideInventory = LandslideInventory::with(['user', 'landslideInventoryValidation'])
            ->findOrFail($id);

        // Pretty JSON string printing for details, analysis, and remarks
        $landslideInventory->details_formatted = json_encode($landslideInventory->details ?? new \stdClass(), JSON_PRETTY_PRINT);
        $landslideInventory->analysis_formatted = json_encode($landslideInventory->analysis ?? new \stdClass(), JSON_PRETTY_PRINT);
        $landslideInventory->remarks_formatted = json_encode($landslideInventory->remarks ?? new \stdClass(), JSON_PRETTY_PRINT);


        return view('pages.landslide-inventory', compact('landslideInventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $landslideInventory = LandslideInventory::with(['user', 'landslideInventoryValidation'])
            ->findOrFail($id);
        $landslideInventoryValidations = LandslideInventoryValidation::orderBy('name')->get();

        // Pretty JSON string printing for details, analysis, and remarks
        $landslideInventory->details_formatted = json_encode($landslideInventory->details ?? new \stdClass(), JSON_PRETTY_PRINT);
        $landslideInventory->analysis_formatted = json_encode($landslideInventory->analysis ?? new \stdClass(), JSON_PRETTY_PRINT);
        $landslideInventory->remarks_formatted = json_encode($landslideInventory->remarks ?? new \stdClass(), JSON_PRETTY_PRINT);


        return view('pages.edit-landslide-inventory', compact('landslideInventory', 'landslideInventoryValidations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $landslideInventory = LandslideInventory::findOrFail($id);

        $request->validate([
            'validation_status' => 'nullable|exists:landslide_inventory_validations,id',
        ]);

        $landslideInventory->validation_status = $request->input('validation_status');
        $landslideInventory->save();

        return redirect()->route('landslide-inventories.show', $landslideInventory->id)
                         ->with('success', 'Landslide Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LandslideInventory  $landslideInventory
     * @return \Illuminate\Http\Response
     */
    // public function destroy(LandslideInventory $landslideInventory)
    // {
    //     //
    // }
}
