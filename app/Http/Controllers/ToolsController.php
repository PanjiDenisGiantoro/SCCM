<?php

namespace App\Http\Controllers;

use App\Models\Boms;
use App\Models\Depreciation;
use App\Models\Equipment;
use App\Models\Tools;
use App\Models\Files;
use App\Models\Location;
use App\Models\Organization;
use App\Models\personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ToolsController extends Controller
{
    public function index()
    {
        return view('tools.index');

    }
    public function create()
    {


        $personelUser = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })
            ->where('status', 1)
            ->get();

        $personelGroup = Organization::latest()->get();
        return view('tools.create',compact('personelGroup','personelUser'));
    }
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->store('tools', 'public');
            } else {
                $imageName = null;
            }

            $facility = Tools::create([
                'name' => $request->nameFacility,
                'id_asset' => 2,
                'code' => 'tools-' . Str::random(8),
                'category' => $request->categoryfacility,
                'account_id' => $request->account,
                'charge_departement_id' => $request->chargemanagement,
                'description' => $request->descriptionnote,
                'status' => $request->online,
                'parent_id' => $request->locationid,
                'parent_id_tools' => $request->equipmentid,
                'photo' => $imageName
            ]);
            if ($request->location == 0) {
                $location = Location::create([
                    'id_asset' => $request->locationid,
                    'model' => 'App\Models\Tools',
                ]);
            } else {
                $location = Location::create([
                    'id_asset' => $request->equipmentid,
                    'model' => 'App\Models\Tools',
                ]);
            }

            if (!empty($request->input('personnel_id'))) {
                foreach ($request->input('personnel_id') as $index => $id_user) {
                    personnel::create([
                        'model_id' => 'App\Models\Tools',
                        'id_asset' => $facility->id,
                        'id_user' => $id_user,
                        'type' => $request->input("personnel_type.$index"),
                    ]);
                }
            }
            if(!empty($request->input('part'))){
                foreach ($request->input('part') as $index => $id_part) {
                    Boms::create([
                        'model' => 'App\Models\Tools',
                        'id_asset' => $facility->id,
                        'quantity' => $request->input("quantity.$index"),
                    ]);
                }
            }

            if(!empty($request->input('meterReading'))){
                foreach ($request->input('meterReading') as $index => $id_part) {
                    Boms::create([
                        'model' => 'App\Models\Tools',
                        'id_asset' => $facility->id,
                        'name_meter' => $request->input("meterReadingUnit.$index"),
                        'meter_number' => $request->input("meterReading.$index"),
                    ]);
                }
            }

            if($request->remaining_life != null){
                Depreciation::create([
                    'asset_id' => $facility->id,
                    'model' => 'App\Models\Tools',
                    'remaining_life' => $request->remaining_life,
                    'purchase_price' => $request->purchase_price,
                    'purchase_date' => $request->purchase_date,
                    'useful_life' => $request->useful_life,
                    'salvage_value' => $request->salvage_value,
                    'annual_depreciation' => $request->annual_depreciation,
                    'depreciation_method' => $request->depreciation_method

                ]);
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
                        'model' => 'App\Model\Equipment',
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
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }


    }
    public function getDataTools(Request $request)
    {
        if ($request->has('parent_id')) {
            return response()->json($this->getChildTools($request->parent_id));
        }

        $facilities = Tools::whereNull('parent_id')->latest()->get();

        return DataTables::of($facilities)
            ->addColumn('expand', function ($facility) {
                $hasChildren = Tools::where('parent_id', $facility->id)->exists();
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
    private function getChildTools($parentId)
    {
        $facilities = Tools::where('parent_id', $parentId)->get();

        foreach ($facilities as $facility) {
            $facility->has_children = Tools::where('parent_id', $facility->id)->exists();
            if ($facility->has_children) {
                $facility->children = $this->getChildTools($facility->id);
            }
        }
        return $facilities;
    }

}
