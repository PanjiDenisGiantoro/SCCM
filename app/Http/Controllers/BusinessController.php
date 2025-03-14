<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\MeterReading;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::latest()->get();
        return view('business.index', compact('business'));

    }

    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'business_name' => 'required',
                'business_classification' => 'nullable',
                'contact_person' => 'nullable',
                'phone' => 'nullable',
                'email' => 'nullable',
                'description' => 'nullable',
                'type_business' => 'nullable',
                'website' => 'nullable',
                'address' => 'nullable',
                'city' => 'nullable',
                'country' => 'nullable',
                'status' => 'nullable',
            ]);

//            photo
            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('business', 'public');
            }else{
                $data['photo'] = null;
            }

            $business = Business::create([
                'code' => 'B' . rand(100000, 999999),
                'business_name' => $data['business_name'],
                'business_classification' => is_array($data['business_classification']) ? implode(',', $data['business_classification']) : $data['business_classification'],
                'phone' => $data['phone'],
                'website' => $data['website'],
                'email' => $data['email'],
                'address' => $data['address'],
                'city' => $data['city'],
                'country' => $data['country'],
                'status' => $data['status'],
                'photo' => $data['photo']
            ]);
            Alert::success('Success', 'Business created successfully');

            return redirect()->route('business.list');

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('business.list');

        }


    }

    public function destroy($id)
    {
        $business = Business::findOrFail($id);
        $business->delete();
        activity()
            ->causedBy(auth()->user())
            ->log('Business deleted');
        Alert::success('Success', 'Business deleted successfully');
        return redirect()->route('business.list');

    }

    public function edit($id)
    {
        $business = Business::findOrFail($id);
        $selectedTypes = explode(',', $business->business_classification);
        return view('business.create', compact('business', 'selectedTypes'));

    }

    public function update(Request $request, $id)
    {
        if (is_array($request->business_classification)) {
            $request->business_classification = implode(',', $request->business_classification);
        }else{
            $request->business_classification = $request->business_classification;
        }


        try {
            $business = Business::find($id);

            $oldPhotoPath = public_path('storage/business/' . $business->photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
            if ($request->hasFile('photo')) {
                $business->photo = $request->file('photo')->store('business', 'public');
            }else{
                $business->photo = $business->photo;
            }

            $business->update([
                'business_classification' => $request->business_classification,
                'business_name' => $request->business_name,
                'phone' => $request->phone,
                'website' => $request->website,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'status' => $request->status,
                'photo' => $business->photo
            ]);
            Alert::success('Success', 'Business updated successfully');
            return redirect()->route('business.list');


        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('business.list');

        }

    }
    public function getData()
    {

        $business = Business::latest()->get();
        return response()->json($business);

    }

    public function getDataMeterReading()
    {
        $meterReading = MeterReading::latest()->get();
        return response()->json($meterReading);
    }
}
