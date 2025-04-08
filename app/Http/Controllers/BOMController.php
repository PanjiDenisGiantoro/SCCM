<?php

namespace App\Http\Controllers;

use App\Models\Boms;
use App\Models\Facility;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class BOMController extends Controller
{
    public function index()
    {
        return view('bom.index');

    }

    public function create()
    {
        $parts = Part::with('boms','categories')->latest()->get();
        return view('bom.create',compact('parts'));
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
            ]);

            foreach($request->parts as $part){
                Boms::create([
                    'name' => $request->name,
                    'id_asset' => $part['id'],
                    'quantity' => $part['qty'],
                    'model' => 'App\Models\Boms',
                ]);
            }

            foreach ($request->assets as $asset) {
                Boms::create([
                    'name' => $request->name,
                    'id_bom' => $asset['id'],
                    'model' => 'App\Models\Boms',
                ]);
            }
            return response()->json(['success' => 'BOM created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getData()
    {
        $bomsCount = Boms::select('name', DB::raw('COUNT(id_asset) as total_assets'))
            ->where('model', 'App\Models\Boms')
            ->groupBy('name')
            ->get();

        return DataTables::of($bomsCount)
            ->addColumn('action', function ($row) {
                return '<a href="'.url('bom/edit/'.$row->name).'" class="btn btn-outline-success   btn-sm">Edit</a>
                    <a href="'.url('bom/destroy/'.$row->name).'" class="btn btn-danger btn-sm">Delete</a>';
            })
            ->editColumn('total_assets', function ($row) {
                return $row->total_assets;
            })
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'total_assets', 'name']) // Render HTML di kolom action
            ->make(true);
    }
    public function destroy($id)
    {
        $boms = Boms::where('name',$id)->get();
        foreach($boms as $bom){
            $bom->delete();
        }
        Alert::success('Success', 'BOM deleted successfully');
        return redirect()->route('bom.list');

    }
    public function getDataAsset()
    {
        $part = Part::with('boms')->latest()->get();
        return response()->json($part);
    }
    public function getDataBom(Request $request)
    {
        $bom = Boms::with('parts')->where('model' , 'App\Models\Boms')
            ->where('id_bom','=',null)
            ->where('name', $request->bom_id)
            ->latest()->get();

        return response()->json($bom);
    }
    public function edit($id)
    {

        $part = Part::leftJoin('boms_managers', 'boms_managers.id_asset', '=', 'parts.id')
            ->where('boms_managers.model', 'App\Models\Boms')
            ->where('boms_managers.name', $id)
            ->get();

        $facilities = Facility::leftJoin('boms_managers', 'boms_managers.id_bom', '=', 'facilities.id')
            ->leftJoin('asset_categories', DB::raw('CAST(facilities.category AS BIGINT)'), '=', 'asset_categories.id')
            ->select('facilities.*', 'asset_categories.category_name', 'boms_managers.quantity','boms_managers.id as bom_id')
            ->where('boms_managers.model', 'App\Models\Boms')
            ->where('boms_managers.name', $id)
            ->get();

        $bomFacilities = $facilities->filter(function($item) {
            return is_null($item->quantity);
        });

        $bomParts = $part->filter(function($item) {
            return !is_null($item->quantity); // Record dengan quantity tidak null (ada part)
        });




        return view('bom.edit', compact('bomParts', 'bomFacilities'));

    }

    public function getlistBom(){
        $bom = Facility::with('categories')->latest()->get();
        return response()->json($bom);


    }

    public function getPart(Request $request)
    {
        $part = Part::with('categories')->where('id', $request->id)->first();
        return response()->json([
            'success' => true,
            'data' => $part
        ]);
    }


}
