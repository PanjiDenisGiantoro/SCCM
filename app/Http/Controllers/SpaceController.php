<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Occupancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SpaceController extends Controller
{
    public function index()
    {
        $occupancy = Occupancy::latest()->get();
        return view('space.index', compact('occupancy'));
    }

    public function create()
    {
        $facility = Facility::latest()->get();
        return view('space.create', compact('facility'));

    }

    public function analytics()
    {
        return view('space.analytic');
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'space_id' => 'required|string',
            'building_ref' => 'required|string',
            'room_name' => 'required|string',
            'purpose' => 'nullable|string',
            'area_size' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'occupancy_rate' => 'nullable|numeric',
            'status' => 'nullable|string',
            'tenant_name' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'lease_number' => 'nullable|string',
            'rental_cost' => 'nullable|numeric',
            'payment_terms' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data ke tabel space
            $facilitiesString = null;
            if (!empty($validated['facilities'])) {
                $facilitiesString = implode(',', $validated['facilities']);
            }

            $space = Occupancy::create([
                'space_id' => $validated['space_id'],
                'building_ref' => $validated['building_ref'],
                'room_name' => $validated['room_name'],
                'purpose' => $validated['purpose'] ?? null,
                'area_size' => $validated['area_size'] ?? null,
                'capacity' => $validated['capacity'] ?? null,
                'occupancy_rate' => $validated['occupancy_rate'] ?? null,
                'status' => $validated['status'] ?? null,
                'tenant_name' => $validated['tenant_name'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'lease_number' => $validated['lease_number'] ?? null,
                'rental_cost' => $validated['rental_cost'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
                'contact_person' => $validated['contact_person'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'facilities' => $facilitiesString,
                'notes' => $validated['notes'] ?? null,
            ]);


            DB::commit();

            return response()->json(['message' => 'Data saved successfully', 'space' => $space], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error saving data', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $space = Occupancy::findOrFail($id);
        $space->delete();
        Alert::success('Success', 'Space deleted successfully');
        return redirect()->route('space.list');
    }

    public function edit($id)
    {
        $oppanancy = Occupancy::find($id);
        $facility = Facility::latest()->get();
        return view('space.create', compact('oppanancy', 'facility'));
    }

    function update(Request $request, $id)
    {

        $validated = $request->validate([
            'space_id' => 'required|string',
            'building_ref' => 'required|string',
            'room_name' => 'required|string',
            'purpose' => 'nullable|string',
            'area_size' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'occupancy_rate' => 'nullable|numeric',
            'status' => 'nullable|string',
            'tenant_name' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'lease_number' => 'nullable|string',
            'rental_cost' => 'nullable|numeric',
            'payment_terms' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $space = Occupancy::findOrFail($id);

            $facilitiesString = null;
            if (!empty($validated['facilities'])) {
                $facilitiesString = implode(',', $validated['facilities']);
            }

            $space->update([
                'space_id' => $validated['space_id'],
                'building_ref' => $validated['building_ref'],
                'room_name' => $validated['room_name'],
                'purpose' => $validated['purpose'] ?? null,
                'area_size' => $validated['area_size'] ?? null,
                'capacity' => $validated['capacity'] ?? null,
                'occupancy_rate' => $validated['occupancy_rate'] ?? null,
                'status' => $validated['status'] ?? null,
                'tenant_name' => $validated['tenant_name'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'lease_number' => $validated['lease_number'] ?? null,
                'rental_cost' => $validated['rental_cost'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
                'contact_person' => $validated['contact_person'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'facilities' => $facilitiesString,
                'notes' => $validated['notes'] ?? null,
            ]);

            DB::commit();

            return response()->json(['message' => 'Data updated successfully', 'space' => $space], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating data', 'error' => $e->getMessage()], 500);
        }
    }

}
