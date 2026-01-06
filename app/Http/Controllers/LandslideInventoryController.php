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
        $landslideInventory->details_formatted = json_encode(json_decode($landslideInventory->details), JSON_PRETTY_PRINT);
        $landslideInventory->analysis_formatted = json_encode(json_decode($landslideInventory->analysis), JSON_PRETTY_PRINT);
        $landslideInventory->remarks_formatted = json_encode(json_decode($landslideInventory->remarks), JSON_PRETTY_PRINT);

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
        $landslideInventory->details_formatted = json_encode(json_decode($landslideInventory->details), JSON_PRETTY_PRINT);
        $landslideInventory->analysis_formatted = json_encode(json_decode($landslideInventory->analysis), JSON_PRETTY_PRINT);
        $landslideInventory->remarks_formatted = json_encode(json_decode($landslideInventory->remarks), JSON_PRETTY_PRINT);

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
