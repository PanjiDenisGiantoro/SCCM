<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Boms;
use App\Models\Facility;
use App\Models\Files;
use App\Models\LogStock;
use App\Models\Organization;
use App\Models\Part;
use App\Models\personnel;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warranties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

class PartController extends Controller
{
    public function index()
    {

        return view('part.index');
    }

    public function create()
    {

        $personelUser = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })
            ->where('status', 1)
            ->get();

        $personelGroup = Organization::latest()->get();

        $facility = Facility::latest()->get();
        $parts = Facility::latest()->get();
        return view('part.create', compact('personelGroup', 'personelUser','parts','facility'));
    }

    public function store(Request $request)
    {
//        dd($request->all());

        $data = $request->all();

        try {

            $part = Part::create([
                'nameParts' => $request->namepart ?? '',
                'category' => $request->categorypart ?? '',
                'id_charge' => $request->id_charge ?? '',
                'id_account' => $request->id_account ?? '',
                'code' => $request->namepart.'-'.Str::random(10),
            ]);
            if (!empty($data['data'])) {
                $stocksData = []; // Menyimpan batch data stok
                $logData = []; // Menyimpan batch data log
                $stockIdMap = []; // Menyimpan ID stok yang baru dibuat

                DB::beginTransaction(); // Mulai transaksi untuk memastikan data tersimpan dengan benar

                try {
                    foreach ($data['data'] as $index => $stock) {
                        // Simpan stok satu per satu untuk mendapatkan ID-nya
                        $newStock = Stock::create([
                            'part_id' => $part->id, // ID unik (bisa disesuaikan)
                            'quantity' => (int) $stock['qtyOnHand'],
                            'stock_min' => (int) $stock['minQty'],
                            'stock_max' => (int) $stock['maxQty'],
                            'description' => $stock['facility'] . ' - ' . $stock['aisle'],
                            'adjustment' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                            'adjustment_by' => auth()->user()->id ?? null,
                            'location' => $stock['facility'],
                            'model' => $stock['aisle'],
                            'status' => $stock['status'],
                        ]);

                        // Simpan ID stok yang baru dibuat
                        $stockIdMap[$index] = $newStock->id;
                    }

                    // Simpan log jika ada
                    if (!empty($data['log'])) {
                        foreach ($data['log'] as $index => $log) {
                            if (isset($stockIdMap[$index])) { // Pastikan stok ada sebelum buat log
                                foreach ($log['date'] as $i => $date) {
                                    $logData[] = [
                                        'stock_id' => $stockIdMap[$index], // Foreign Key ke stocks.id
                                        'user_id' => auth()->user()->id ?? null,
                                        'description' => $log['description'][$i],
                                        'old_quantity' => (int) $log['oldQty'][$i],
                                        'new_quantity' => (int) $log['newQty'][$i],
                                    ];
                                }
                            }
                        }

                        // Simpan log stok dalam batch
                        LogStock::insert($logData);
                    }

                    DB::commit(); // Simpan semua perubahan ke database
                } catch (\Exception $e) {
                    Log::error('Gagal menyimpan data: ' . $e->getMessage());
                    DB::rollBack(); // Batalkan semua perubahan jika terjadi kesalahan
                    return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
                }
            }


            if (isset($data['personnel_id']) && count($data['personnel_id']) > 0) {
                $personnelData = [];
                foreach ($data['personnel_id'] as $index => $id) {
                    $personnelData[] = [
                        'id_asset' => $part->id, // Jika ada, bisa diisi dari request
                        'model_id' => 'App\Models\Part',
                        'id_user' => $id,  // ID dari personnel_id array
                        'type' => $data['personnel_type'][$index], // Sesuai index
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $personnel = personnel::insert($personnelData);
            }


            $bomData = json_decode($request->bomData, true); // Decode JSON ke array


            if ($request->bomData == '[]') {
                $bomdataperson = []; // Pastikan array kosong sudah dideklarasikan

                foreach ($bomData as $data) {
                    $bomdataperson[] = [
                        'id_asset' => $data['asset'] ?? null,  // Isi dari asset
                        'id_bom' => $data['bomControl'] ?: null, // Bisa kosong
                        'quantity' => $data['quantity'] ?? '0', // Default '0' jika kosong
                        'model' => 'App\Model\Part',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Hanya insert jika ada data
                if (!empty($bomdataperson)) {
                    Boms::insert($bomdataperson);
                }
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'bomData tidak ditemukan atau kosong.',
                ], 422);
            }

            $warranties = $request->input('warranties');

            $dataToInsert = [];
            $count = count($warranties['type']); // Hitung jumlah warranty

            for ($i = 0; $i < $count; $i++) {
                $dataToInsert[] = [
                    'type' => $warranties['type'][$i],
                    'provider' => $warranties['provider'][$i],
                    'usage_term' => $warranties['usage_term'][$i],
                    'expiry' => $warranties['expiry'][$i],
                    'meter_unit' => $warranties['meter_unit'][0] ?? null, // Ambil pertama karena 1 saja
                    'meter_limit' => $warranties['meter_limit'][$i] ?? null,
                    'certificate' => $warranties['certificate'][$i],
                    'description' => $warranties['description'][$i],
                    'model' => 'App\Model\Part',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Warranties::insert($dataToInsert); // Insert batch


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
                        'model' => 'App\Model\Part',
                        'id_part' => $part->id,
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
                'status' => 'success',
            ]);


        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);

        }

    }

    public function getCategories()
    {
        $categories = AssetCategory::with('children')
            ->whereHas('assets', function ($query) {
                $query->where('type_id', 4);
            })
            ->whereNull('parent_id') // Ambil parent saja
            ->get();

        return response()->json($categories);
    }

    public function getFacility()
    {

        $categories = AssetCategory::with('children')
            ->whereHas('assets', function ($query) {
                $query->where('type_id', 1);
            })
            ->whereNull('parent_id') // Ambil parent saja
            ->get();

        return response()->json($categories);
    }
    public function getFacility2()
    {

        $categories = AssetCategory::with('children')
            ->whereHas('assets', function ($query) {
                $query->where('type_id', 2);
            })
            ->whereNull('parent_id') // Ambil parent saja
            ->get();

        return response()->json($categories);
    }
    public function getFacility3()
    {

        $categories = AssetCategory::with('children')
            ->whereHas('assets', function ($query) {
                $query->where('type_id', 3);
            })
            ->whereNull('parent_id') // Ambil parent saja
            ->get();

        return response()->json($categories);
    }

    public function storecategories(Request $request)
    {
        $category = AssetCategory::create([
            'category_name' => $request->name,
            'parent_id' => $request->parent_id,
            'type_id' => 4
        ]);

        return response()->json($category);
    }
    public function storecategories2(Request $request)
    {
        $category = AssetCategory::create([
            'category_name' => $request->name,
            'parent_id' => $request->parent_id,
            'type_id' => 2
        ]);

        return response()->json($category);
    }
    public function storecategories3(Request $request)
    {
        $category = AssetCategory::create([
            'category_name' => $request->name,
            'parent_id' => $request->parent_id,
            'type_id' => 3
        ]);

        return response()->json($category);
    }

    public function getPart(Request $request)
    {
        $part = Part::latest()->get();
        return response()->json($part);
    }

    public function getData()
    {
        $bomsCount = Part::with('categories')->latest()
            ->get();

        return DataTables::of($bomsCount)
            ->editColumn('code', function ($row) {
                return $row->code ?? '-';
            })
            ->editColumn('category_name', function ($row) {
                return $row->categories->category_name ?? '-';
            })
            ->editColumn('nameParts', function ($row) {
                return $row->nameParts ?? '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->addColumn('qrcode', function ($row) {
                if(empty($row->code)){
                    return '-';
                }else{
                $qrcode = QrCode::size(100)->generate($row->code);
                return $qrcode;
                }
            })
            ->editColumn('action', function ($row) {
                return '<a href="'.url('part/show/'.$row->id).'" class="btn btn-outline-success btn-sm">Edit</a>
                <a href="'.url('part/destroy/'.$row->id).'" class="btn btn-danger btn-sm">Delete</a>';

            })
            ->rawColumns(['action', 'code', 'nameParts','qrcode','category_name']) // Render HTML di kolom action
            ->make(true);
    }
    public function listBom()
    {
        $bom = Boms::where('model' , 'App\Models\Boms')
            ->where('id_bom','!=',null)
            ->latest()->get();

        return response()->json($bom);
    }

    public function show($id)
    {
        $personelUser = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'super_admin');
        })
            ->where('status', 1)
            ->get();

        $personelGroup = Organization::latest()->get();
        $parts = Facility::latest()->get();
        $partdata = Part::with(['categories', 'receiptbodies.receipt.business','purchasebodies.getpurchaseorder.business','charge','accounts'])->findOrFail($id);
        $category = AssetCategory::with('children')->whereNull('parent_id')->get();
//        return $partdata;
        $facility = Facility::latest()->get();
        return view('part.create', compact('parts', 'personelUser', 'personelGroup','partdata','facility','category'));


    }
}
