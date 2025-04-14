<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Permits;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PermitController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        $permits = Permits::all(); // atau pakai pagination: Permit::paginate(10);
        return view('permit.index',compact('permits','facilities'));
    }

    public function store(Request $request)
    {

        $permit = Permits::create([
            "permit_type" => $request->permit_type,
            "facility_reference" => $request->facility_reference,
            "issued_by" => $request->issued_by,
            "expiration_date" => $request->expiration_date,
            "status" => $request->status,
            "compliance_documents" => $request->compliance_documents
        ]);
        Alert::success('Success', 'Data added successfully');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $permit = Permits::findOrFail($id);
        $permit->delete();
        Alert::success('Success', 'Permit deleted successfully');
        return redirect()->route('permit.list');

    }
    public function edit($id)
    {
        $permit = Permits::findOrFail($id);
        $facilities = Facility::all();
        return view('permit.edit',compact('permit','facilities'));
    }
    public function update(Request $request, $id)
    {
        $permit = Permits::findOrFail($id);
        $permit->update([
            "permit_type" => $request->permit_type,
            "facility_reference" => $request->facility_reference,
            "issued_by" => $request->issued_by,
            "expiration_date" => $request->expiration_date,
            "status" => $request->status,
            "compliance_documents" => $request->compliance_documents
        ]);
        Alert::success('Success', 'Data updated successfully');
        return redirect()->route('permit.list');
    }
}
