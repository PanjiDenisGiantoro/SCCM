<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Asset;
use App\Models\Boms;
use App\Models\ChargeDepartment;
use App\Models\Facility;
use App\Models\Files;
use App\Models\Location;
use App\Models\Organization;
use App\Models\personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('asset.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $personelUser = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })
            ->where('status', 1)
            ->get();

        $personelGroup = Organization::latest()->get();
        return view('asset.create1', compact('personelGroup', 'personelUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {

            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->store('facilities', 'public');
            }else{
                $imageName = null;
            }

            $facility = Facility::create([
                'name' => $request->nameFacility,
                'id_asset' => 1,
                'code' => 'Fac-' . Str::random(8),
                'category' => $request->categoryfacility,
                'account_id' => $request->account,
                'charge_departement_id' => $request->chargemanagement,
                'description' => $request->descriptionnote,
                'status' => $request->online,
                'parent_id' => $request->locationid,
                'photo' => $imageName
            ]);

            if ($request->location == 0) {
                $location = Location::create([
                    'id_asset' => $request->locationid,
                    'model' => 'App\Models\Facility',
                ]);
            } else {
                $location = Location::create([
                    'address' => $request->asset_address,
                    'city' => $request->asset_city,
                    'country' => $request->asset_country,
                    'postal_code' => $request->asset_postal,
                    'province' => $request->asset_province,
                    'model' => 'App\Models\Facility',
                    'id_asset' => $facility->id
                ]);
            }

            if (!empty($request->input('personnel_id'))) {
                foreach ($request->input('personnel_id') as $index => $id_user) {
                    personnel::create([
                        'model_id' => 'App\Models\Facility',
                        'id_asset' => $facility->id,
                        'id_user' => $id_user,
                        'type' => $request->input("personnel_type.$index"),
                    ]);
                }
            }



            if (!empty($request->bomData)) { // Pastikan bomData ada dan tidak kosong
                $bomData = json_decode($request->bomData, true); // Decode JSON ke array

                if (is_array($bomData) && count($bomData) > 0) { // Cek apakah array valid dan memiliki isi
                    $bomdataperson = [];

                    foreach ($bomData as $data) {
                        $bomdataperson[] = [
                            'id_asset' => $data['asset'] ?? null,
                            'id_bom' => $data['bomControl'] ?? null,
                            'quantity' => $data['quantity'] ?? '0',
                            'model' => 'App\Model\Facility',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (!empty($bomdataperson)) {
                        Boms::insert($bomdataperson);
                    }
                } else {
                 Log::error('BOM data is not valid or empty.');
                }
            }else{
                Log::error('BOM data is not valid or empty.');
            }


            if (isset($data['files']) && count($data['files']) > 0) {
                $dataToInsert = [];

                foreach ($data['files'] as $index => $fileData) {
                    $type = $fileData['type'];
                    $noteName = $fileData['name'] ?? null;
                    $noteContent = $request->input("files.$index.noteContent") ?? null;
                    $file = $request->file("files.$index.file");
                    $nameFile = null;
                    $size = '-';
                    $modified = now()->toDateTimeString();

                    if ($file) {
                        $nameFile = $file->getClientOriginalName();
                        $file->move(public_path('file'), $nameFile);
                        $size = round($file->getSize() / 1024, 2) . " KB"; // Convert ke KB
                    }

                    $nameLink = $request->input("files.$index.nameLink") ?? null;
                    $link = $request->input("files.$index.link") ?? null;
                    $noteLink = $request->input("files.$index.noteLink") ?? null;

                    $dataToInsert[] = [
                        'type' => $type,
                        'model' => 'App\Model\Facility',
                        'id_part' => $facility->id,
                        'note_name' => $noteName,
                        'note' => $noteContent,
                        'file' => $nameFile,
                        'size' => $size,
                        'modified' => $modified,
                        'name_link' => $nameLink,
                        'note_link' => $noteLink,
                        'link' => $link,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Files::insert($dataToInsert); // Batch insert
            }

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        try {
            $facility = Facility::with(['location', 'personnel', 'boms', 'files'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $facility
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        //
    }

    public function list_account()
    {
        $account = Account::latest()->get();
        return response()->json($account);
    }

    public function store_account(Request $request)
    {
        try {
            $account = Account::create([
                'name' => $request->account,
                'description' => $request->description,
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);

        }
    }

    public function destroy_account($id)
    {
        $account = Account::find($id);
        $account->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function charge_list()
    {
        $charge = ChargeDepartment::with('facility')->latest()->get();
        return response()->json($charge);
    }

    public function charge_store(Request $request)
    {
        try {
            $charge = ChargeDepartment::create([
                'name' => $request->code,
                'description' => $request->description,
                'id_facility' => $request->facility
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);

        }

    }

    public function charge_delete($id)
    {
        dd($id);
    }

    public function facility()
    {
        return view('asset.facility');
    }

    public function getDataPart($id)
    {
        $part = Boms::with('parts')->where('model', 'App\Models\Boms')->where('id_bom', $id)->get();
        return response()->json($part);

    }

    public function listBom()
    {
        $bom = Boms::where('model', 'App\Models\Boms')
            ->where('id_bom', '!=', null)
            ->latest()->get();

        return response()->json($bom);
    }

    public function getpartBom(Request $request)
    {
        $bom = Boms::where('model', 'App\Models\Boms')
            ->where('id', $request->bom_id)
            ->first();

        $part = Boms::with('parts')
            ->where('model', 'App\Models\Boms')
            ->where('name', $bom->name)->get();

        return response()->json($part);

    }

    public function getFacilities()
    {
        $facility = Facility::latest()->get();
        return response()->json($facility);
    }

    public function getLocationDetails(Request $request)
    {
        $location = Location::where('id_asset', $request->id)->first();
        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'Location not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'address' => $location->address,
                'city' => $location->city,
                'province' => $location->province,
                'country' => $location->country,
                'postal_code' => $location->postal_code
            ]
        ]);
    }

    public function getDataFacility(Request $request)
    {
        if ($request->has('parent_id')) {
            return response()->json($this->getChildFacilities($request->parent_id));
        }

        $facilities = Facility::whereNull('parent_id')->latest()->get();

        return DataTables::of($facilities)
            ->addColumn('expand', function ($facility) {
                $hasChildren = Facility::where('parent_id', $facility->id)->exists();
                return $hasChildren ? '<button class="btn btn-outline-info btn-sm toggle-child" data-id="' . $facility->id . '">+</button>' : '';
            })
            ->editColumn('name', function ($facility) {
                return $facility->name;
            })
            ->editColumn('status', function ($facility) {
                return $facility->status == 1
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->editColumn('description', function ($facility) {
                return $facility->description ?? '-';
            })
            ->addColumn('action', function ($facility) {
                return '
            <button class="btn btn-outline-info btn-sm editBtn" data-id="' . $facility->id . '">
                <iconify-icon icon="lucide:edit"></iconify-icon>
            </button>
                <button class="btn btn-outline-info btn-sm viewBtn" data-id="' . $facility->id . '">
                <iconify-icon icon="lucide:eye"></iconify-icon>
            </button>'
                    ;
            })
            ->rawColumns(['expand', 'status', 'action'])
            ->make(true);
    }

// Fungsi rekursif untuk mendapatkan semua anak secara bertingkat
    private function getChildFacilities($parentId)
    {
        $facilities = Facility::where('parent_id', $parentId)->get();

        foreach ($facilities as $facility) {
            $facility->has_children = Facility::where('parent_id', $facility->id)->exists();
            if ($facility->has_children) {
                $facility->children = $this->getChildFacilities($facility->id);
            }
        }

        return $facilities;
    }

}
