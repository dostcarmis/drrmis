<?php

namespace App\Http\Controllers;

use App\Models\LandslideInventory;
use App\Models\LandslideInventoryCandidate;
use App\Models\LandslideInventoryValidation;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use JsonPrettify;

class LandslideInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $landslides = LandslideInventoryCandidate::with(['validator', 'landslideInventoryValidation'])
            ->orderBy('created_at', 'desc')->get();

        return view('pages.viewlandslide_inventory_candidates', compact('landslides'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $viewAll = filter_var($request->input('view-all', false), FILTER_VALIDATE_BOOLEAN);

        $landslideInventory = 
            LandslideInventoryCandidate::with([
                'validator', 
                'landslideInventoryValidation', 
                'landslideInventory'
            ])
            ->findOrFail($id);

        if ($viewAll) {
            $landslideInventory->location = $landslideInventory->landslideInventory->location;
            $landslideInventory->analysis = $landslideInventory->landslideInventory->analysis;

            // Pretty JSON string printing for details, analysis, and analysis
            $landslideInventory->details_formatted = json_encode($landslideInventory->landslideInventory->details ?? new \stdClass(), JSON_PRETTY_PRINT);
            $landslideInventory->analysis_formatted = json_encode($landslideInventory->landslideInventory->analysis ?? new \stdClass(), JSON_PRETTY_PRINT);
            $landslideInventory->remarks_formatted = json_encode($landslideInventory->landslideInventory->remarks ?? new \stdClass(), JSON_PRETTY_PRINT);

            return view('pages.viewlandslide_inventory', compact('landslideInventory'));
        }

        // Pretty JSON string printing for analysis, and remarks
        $landslideInventory->analysis_formatted = JsonPrettify::prettify(
            $landslideInventory->landslideInventory->analysis, 
            ['candidates']
        );
        $landslideInventory->remarks_formatted = json_encode($landslideInventory->landslideInventory->remarks ?? new \stdClass(), JSON_PRETTY_PRINT);

        $incidentImages = collect($landslideInventory->incident_images);
        // dd($incidentImages);

        return view('pages.viewlandslide_inventory_candidate', compact(
            'landslideInventory',
            'incidentImages'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $landslideInventory = 
            LandslideInventoryCandidate::with([
                'validator', 
                'landslideInventoryValidation', 
                'landslideInventory'
            ])
            ->findOrFail($id);
        $landslideInventoryValidations = LandslideInventoryValidation::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $municipalities = Municipality::orderBy('name')->get();

        // Pretty JSON string printing for analysis, and remarks
        $landslideInventory->analysis_formatted = JsonPrettify::prettify(
            $landslideInventory->landslideInventory->analysis, 
            ['candidates']
        );
        $landslideInventory->remarks_formatted = json_encode($landslideInventory->landslideInventory->remarks ?? new \stdClass(), JSON_PRETTY_PRINT);

        return view('pages.editlandslide_inventory_candidate', compact(
            'landslideInventory',
            'landslideInventoryValidations',
            'provinces',
            'municipalities'
        ));
    }

    /**
     * Update the specified landslide inventory candidate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $landslideInventory = LandslideInventoryCandidate::findOrFail($id);

        // Validate request
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'province_id' => 'nullable|integer|exists:tbl_provinces,id',
            'municipality_id' => 'nullable|integer|exists:tbl_municipality,id',
            'location' => 'required|string|max:255',
            'area_m2' => 'required|numeric|min:0',
            'validation_id' => 'required|integer|exists:landslide_inventory_validations,id',
            'deleted_images' => 'nullable|string',
            'candidateimages' => 'nullable|string',
        ]);

        // Handle deleted images
        $currentImages = [];
        if (!empty($landslideInventory->incident_images)) {
            $currentImages = is_string($landslideInventory->incident_images) 
                ? json_decode($landslideInventory->incident_images, true) 
                : $landslideInventory->incident_images;
        }

        if ($request->has('deleted_images') && !empty($request->deleted_images)) {
            $deletedImages = json_decode($request->deleted_images, true);
            
            if (is_array($deletedImages) && is_array($currentImages)) {
                // Remove deleted images from array
                foreach ($deletedImages as $key) {
                    if (isset($currentImages[$key])) {
                        // Delete physical file (remove -@ suffix if exists)
                        $filePath = str_replace('-@', '', $currentImages[$key]);
                        $fullPath = public_path($filePath);
                        
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                        
                        unset($currentImages[$key]);
                    }
                }
                
                // Re-index array
                $currentImages = array_values($currentImages);
            }
        }

        // Handle candidateimages from dropzone
        if ($request->has('candidateimages') && !empty($request->candidateimages)) {
            $uploadedImages = explode(',', $request->candidateimages);
            $cleanedUploads = array_filter(array_map(function($img) {
                return str_replace('-@', '', trim($img));
            }, $uploadedImages));
            $currentImages = array_values(array_unique(array_merge($currentImages, $cleanedUploads)));
        }

        $landslideInventory->update([
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'province_id' => $validatedData['province_id'] ?? null,
            'municipality_id' => $validatedData['municipality_id'] ?? null,
            'location' => $validatedData['location'],
            'area_m2' => $validatedData['area_m2'],
            'validation_id' => $validatedData['validation_id'],
            'validator_id' => Auth::user()->id,
            'incident_images' => !empty($currentImages) ? json_encode($currentImages, JSON_UNESCAPED_SLASHES) : null,
        ]);

        Session::flash('message', 'Landslide inventory candidate updated successfully.');

        return redirect()
            ->route('landslide-inventories.show', $landslideInventory->id);
    }

    /**
     * Upload image for the specified landslide inventory candidate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request, $id)
    {
        $candidate = LandslideInventoryCandidate::findOrFail($id);
        
        // Validate file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('files/1/landslide_inventory_images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Use original filename
            $filename = $file->getClientOriginalName();
            
            // Move file to destination
            $file->move($uploadPath, $filename);
            
            // Get relative path for storage (without baseUrl)
            $relativePath = 'files/1/landslide_inventory_images/' . $filename;

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'path' => url($relativePath)
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
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

    /**
     * Authenticate user and set session cookie for frontend application
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Auth\AuthenticationException if user is not authenticated
     */
    public function login(Request $request) 
    {
        // TODO: Implement auto login for CLOUD App
        // $user = Auth::user();
        
        // if ($user) {
        //     $token = Str::random(80);
        //     $user->update(['c_token' => $token]);

        //     $frontendUrl = config('integration.clouds.app_url'); 
        //     $parsedUrl = parse_url($frontendUrl);
        //     $host = $parsedUrl['host'] ?? null;
            
        //     $isSecure = isset($parsedUrl['scheme']) && $parsedUrl['scheme'] === 'https';
            
        //     // For localhost, domain MUST be null. For production, use the host.
        //     $domain = ($host === 'localhost' || $host === '127.0.0.1') ? null : $host;

        //     $cookie = cookie(
        //         'c_token', 
        //         $token, 
        //         60,          // Minutes
        //         '/',            // Path
        //         $domain,      // Domain
        //         $isSecure,    // Secure
        //         false,      // HttpOnly (False so React can read it)
        //         false,           // Raw
        //         'Lax'       // SameSite
        //     );

        //     return redirect($frontendUrl)->withCookie($cookie);
        // }

        // return redirect(url('/auth/login'));

        return redirect(config('integration.clouds.app_url'));
    }
}
