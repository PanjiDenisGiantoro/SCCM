<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Business;
use App\Models\ChargeDepartment;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Part;
use App\Models\Tools;
use App\Models\User;
use App\Models\Work_orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = Work_orders::latest()->get();
        return view('wo.index',compact('workOrders'));

    }
    public function create()
    {

        $business = Business::latest()->get();
        $workOrders = Work_orders::whereNotIn('work_order_status', ['complete', 'cancel'])
            ->get();
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get();
        $business = Business::latest()->get();


        $data = $facilities->merge($equipments)->merge($tools);

        $groupedData = $data->groupBy('type')->map(function ($items, $key) {
            return [
                'text' => ucfirst($key), // Menjadikan nama grup lebih rapi
                'children' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->name
                    ];
                })->values()
            ];
        })->values(); // Pastikan format data sesuai untuk Select2

        $client = Client::with('users')->where('id_user', Auth::user()->id)->first();

        if(!empty($client) || !empty($client->users)){
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')
                ->where('created_user', $client->id)
                ->latest()->get();
        }else{
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')->latest()->get();
        }
        $account = Account::latest()->get();
        $charge_account = ChargeDepartment::latest()->get();
        $parts = Part::with('categories')->latest()->get();
        return view('wo.create',compact('groupedData','users','account','charge_account','parts','workOrders','business'));

    }
    public function getData()
    {
        $wo = Work_orders::latest()->get();

        return DataTables::of($wo)
            ->addColumn('action', function ($wo) {
                return '<a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="edit(' . $wo->id . ')"><i class="fa fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="destroy(' . $wo->id . ')"><i class="fa fa-trash"></i> Delete</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
//        dd($request->all());
        try {
            if(!empty($request->work_order_code)) {
                $part = Part::where('code', $request->asset_id)->first();

                $savedFiles = [];

                // Simpan setiap file yang dikirim dalam Base64
                foreach ($request->file as $index => $base64Image) {
                    try {
                        // Decode Base64
                        $imageData = base64_decode($base64Image);

                        // Buat nama file unik
                        $fileName = 'wo_' . time() . "_$index.jpg";

                        // Simpan ke storage Laravel (storage/app/public/wo)
                        Storage::disk('public')->put("wo/$fileName", $imageData);

                        // Simpan path file ke dalam array
                        $savedFiles[] = "wo/$fileName";
                    } catch (\Exception $e) {
                        Log::error('Gagal menyimpan file: ' . $e->getMessage());
                    }
                }

                // Insert Work Order into the database
                $wo = Work_orders::create([
                    'work_order_status' => $request->work_order_status,
                    'code' => $request->work_order_code,
                    'parent_id' => $request->parent_id,
                    'asset_id' => $part->id,
                    'maintenance_id' => $request->maintenance,
                    'project_id' => $request->project_id,
                    'work_order_date' => $request->suggest,
                    'completed_date' => $request->suggest_complete,
                    'priority' => $request->priority,
                    'assign_from' => $request->user_id,
                    'assign_to' => $request->assign_complete,
                    'estimate_hours' => $request->labor,
                    'actual_hours' => $request->actual_labor,
                    'problem_code' => $request->problem_code,
                    'file' => json_encode($savedFiles),  // Store as JSON string
                    'description' => $request->description,
                    'id_account' => $request->account,
                    'id_charge' => $request->change_department,
                ]);

                // Optionally, send a WhatsApp message (using a service)
                $this->sendWhatsAppMessage('6289522900800', 'Work order created: ' . $wo->code);

            } else {
                // Default creation if work_order_code is empty
                $wo = Work_orders::create([
                    'work_order_status' => $request->name,
                    'code' => 'WO-' . date('Y') . '-' . date('m') . '-' . date('d') . '-' . rand(1000, 9999),
                    'parent_id' => $request->parent_id,
                    'asset_id' => $request->asset_id,
                    'maintenance_id' => $request->maintenance,
                    'project_id' => $request->project_id,
                    'work_order_date' => $request->suggest,
                    'completed_date' => $request->suggest_complete,
                    'priority' => $request->priority,
                    'assign_from' => $request->assign,
                    'assign_to' => $request->assign_complete,
                    'estimate_hours' => $request->labor,
                    'actual_hours' => $request->actual_labor,
                    'problem_code' => $request->problem_code,
                    'file' => json_encode([]),  // Empty array as JSON string
                    'description' => $request->description,
                    'id_account' => $request->account,
                    'id_charge' => $request->change_department,
                ]);
            }



//            parent data


            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Data saved successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function show($id)
    {
        $wo = Work_orders::findOrFail($id);
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get();
        $business = Business::latest()->get();

        $data = $facilities->merge($tools)->merge($equipments)->merge($part);

        $groupedData = $data->groupBy('type')->map(function ($items, $key) {
            return [
                'text' => ucfirst($key), // Menjadikan nama grup lebih rapi
                'children' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'text' => $item->name
                    ];
                })->values()
            ];
        })->values(); // Pastikan format data sesuai untuk Select2

        $client = Client::with('users')->where('id_user', Auth::user()->id)->first();

        if(!empty($client) || !empty($client->users)){
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')
                ->where('created_user', $client->id)
                ->latest()->get();
        }else{
            $users = User::with('roles.permissions', 'userOrganitations', 'divisions')->latest()->get();
        }
        return view('wo.create',compact('groupedData','users','wo'));

    }
    private function sendWhatsAppMessage($phoneNumber, $message)
    {
        $url = "http://localhost:5001/message/send-text?session=mysession&to=$phoneNumber&text=$message";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            echo 'Message sent successfully!';
        }

    }
    public function getWorkOrders(){
        $workOrders = Work_orders::whereNotIn('status', ['complete', 'cancel'])
            ->get();
        // Kembalikan data dalam format JSON
        return response()->json($workOrders);
    }
}
