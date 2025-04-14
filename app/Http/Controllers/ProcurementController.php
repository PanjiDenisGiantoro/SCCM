<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Approval_layers;
use App\Models\Approval_process;
use App\Models\Approvaluser;
use App\Models\Business;
use App\Models\ChargeDepartment;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Part;
use App\Models\purchaseAdditional;
use App\Models\PurchaseBodies;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderAdditional;
use App\Models\PurchaseOrderBodies;
use App\Models\Purchases;
use App\Models\Receipt;
use App\Models\ReceiptBody;
use App\Models\Tools;
use App\Models\User;
use App\Models\Work_orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcurementController extends Controller
{
    public function index()
    {
        $receipts = Receipt::with([
            'receipt_body.part',
            'receipt_body.equipment',
            'receipt_body.tools',
            'receipt_body.facility',
            'business',
            'pos'
        ])->get();
//        return $receipts;
        return view('receipt.list');
    }
    public function create()
    {
        $purchaseOrder = PurchaseOrder::where('status','1')->latest()->get();
//        format code dengan tanggal dan no rand
        $code = 'RECEIPT-'.date('Y-m-dHi').'-'.mt_rand(1000, 9999);
        return view('receipt.create',compact('purchaseOrder','code'));
    }
    public function purchase_index()
    {
        $purchases = Purchases::with(['purchaseAdditional', 'purchaseBodies'])->orderBy('created_at', 'desc')->get();

        return view('purchase.list',compact('purchases'));
    }
    public function purchase_create()
    {
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get(); // Perbaikan kutip ganda
        $business = Business::latest()->get();
        $data = $part->merge($equipments)->merge($tools);
        $code = 'PR-' . date('Ymd') . '-' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $account = Account::latest()->get();
        $charge = ChargeDepartment::latest()->get();
        $facilities = Facility::with('children')->whereNull('parent_id')->latest()->get();
        $wo = Work_orders::latest()->get();

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
        })->values();
        return view('purchase.create', compact('business','account', 'charge', 'facilities','data','code','wo','groupedData'));
    }
    public function store(Request $request)
    {
//        dd(request()->all());

        try {

            if ($request->hasFile('supporting_documents')) {
                $data['doc'] = $request->file('supporting_documents')->store('purchase', 'public');
            }else{
                $data['doc'] = null;
            }
            $purchase = Purchases::create([
                'no_pr' => request('pr_number'),
                'request_date' => request('request_date'),
                'required_date' => request('required_date'),
                'description' => request('notes'),
                'total' => request('totalAmount'),
                'status' => 0,
                'doc' => $data['doc'],
                'business_id' => request('business'),
                'user_id' => auth()->user()->id
            ]);

            $purchaseAdd = purchaseAdditional::create([
                'purchase_id' => $purchase->id,
                'account_id' => request('account'),
                'charge_department' => request('chargemanagement'),
                'wo_id' => request('work_order'),
                'facility_id' => request('ship_to_location'),
                'asset_id' => request('impacted_asset'),
                'impacted_production' => request('production_impact'),
            ]);

            for ($i = 0; $i < count(request('item_code')); $i++) {
                if (request('item_code')[$i] == 'custom') {
                  PurchaseBodies::create([
                    'purchase_id' => $purchase->id,
                    'part_id' => request('custom_item_name')[$i],
                    'qty' => request('quantity')[$i],
                    'unit_price' => request('unit_price')[$i],
                    'total_price' => request('total_price')[$i],
                      'model' => request('model')[$i]
                  ]);
                } else {
                  PurchaseBodies::create([
                    'purchase_id' => $purchase->id,
                    'part_id' => request('item_code')[$i],
                    'qty' => request('quantity')[$i],
                    'unit_price' => request('unit_price')[$i],
                    'total_price' => request('total_price')[$i],
                      'model' => request('model')[$i]
                  ]);
                }
            }

            $purchaseTotal = (float) $purchase->total; // Ubah ke float

            $approve = Approval_layers::join('approval_process', 'approval_layers.process_id', '=', 'approval_process.process_id')
                ->where('approval_process.process_name', 'PR')
                ->whereRaw('? BETWEEN approval_process.budget AND approval_process.max_budget', [$purchaseTotal])
                ->get();


            foreach ($approve as $key => $value) {
                Approvaluser::create([
                    'process_id' => $value->process_id,
                    'user_id' => $value->role_id,
                    'approval_required' => 'PENDING',
                    'approve_id' => $purchase->id,
                    'model' => 'App/Models/Purchases'
                ]);
            }


            Alert::success('Success', 'Purchase Request Created Successfully');
            return redirect()->route('purchase.list');

        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('purchase.list');

        }

    }
    public function getData()
    {
        $purchases = Purchases::select('id', 'no_pr', 'request_date', 'required_date', 'description', 'total', 'status');

        return DataTables::of($purchases)
            ->addColumn('status', function ($purchase) {
                if ($purchase->status == 0) {
                    return '<span class="badge bg-warning">Pending</span>';
                } elseif ($purchase->status == 1) {
                    return '<span class="badge bg-success">Approved</span>';
                } elseif ($purchase->status == 2) {
                    return '<span class="badge bg-danger">Rejected</span>';
                }
            })
            ->addColumn('action', function ($purchase) {
                $actions = '
    <div class="btn-group">
        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="' . route('purchase.show', $purchase->id) . '">View</a></li>';

                // Tambahkan Edit dan Delete jika status bukan Approved (1)
                if ($purchase->status != 1 && $purchase->status != 2) {
                    $actions .= '
            <li><a class="dropdown-item" href="' . route('purchase.edit', $purchase->id) . '">Edit</a></li>
          ';
                }

                $actions .= '</ul></div>';

                return $actions;
            })

            ->rawColumns(['status', 'action'])
            ->make(true);

    }
    public function show($id)
    {

        $purchase = Purchases::with([
            'purchaseBodies.part',
            'purchaseBodies.equipment',
            'purchaseBodies.tools',
            'purchaseBodies.facility',
        ])->find($id);

//        dd($purchase);
        $total = (int) $purchase->total;

        $approve = Approval_process::join('approval_layers', 'approval_process.process_id', '=', 'approval_layers.process_id')
            ->where('process_name','PR')
            ->where('budget','<',$total)
            ->where('max_budget','>=',$total)
            ->pluck('role_id')->toArray();

        $business = Business::find($purchase->business_id);
        $client = Client::where('id_user', $purchase->user_id)->first();
        if(empty($client)){
            $user = User::where('id', $purchase->user_id)->first();
            if(!empty($user->created_user)){
                $clients = Client::where('id', $user->created_user)->first();
            }else{
                $clients = null;
            }
        }else{
            $clients = $client;
        }

        $approveuser = Approval_process::join('approvaluser', 'approval_process.process_id', '=', 'approvaluser.process_id')
            ->where('process_name','PR')
            ->where('approve_id', $id)
            ->where('model','App/Models/Purchases')
            ->where('user_id',Auth::user()->id)->first();


        if(empty($approveuser)){
            $approveuser = null;
        }else{
            $approveuser = $approveuser;
        }

        $approve_user = Approvaluser::with('user')->join('approval_process', 'approvaluser.process_id', '=', 'approval_process.process_id')
            ->where('process_name','PR')
            ->where('approve_id', $id)
            ->where('budget','<',$total)
            ->where('max_budget','>=',$total)
            ->where('model','App/Models/Purchases')
            ->get();


        return view('purchase.detail',compact('purchase','business','clients','approve','approveuser','approve_user'));

    }
    public function download($id)
    {
        $purchase = Purchases::with([
            'purchaseBodies.part',
            'purchaseBodies.equipment',
            'purchaseBodies.tools',
            'purchaseBodies.facility',
        ])->find($id);
        $business = Business::find($purchase->business_id);
        $client = Client::where('id_user', $purchase->user_id)->first();
        if(empty($client)){
            $user = User::where('id', $purchase->user_id)->first();
            if(!empty($user->created_user)){
                $clients = Client::where('id', $user->created_user)->first();
            }else{
                $clients = null;
            }
        }else{
            $clients = $client;
        }


        $pdf = Pdf::loadView('purchase.download', compact('purchase', 'clients', 'business'));

        return $pdf->download('purchase_request_'.$purchase->no_pr.'.pdf');
    }
    public function approve($id,Request $request)
    {
//        dd($request->all());

        $approve  = Approvaluser::join('approval_process', 'approvaluser.process_id', '=', 'approval_process.process_id')
            ->where('process_name','PR')
            ->where('approve_id', $request->id_pr)
            ->where('approvaluser.user_id', Auth::user()->id)
            ->where('model','App/Models/Purchases')
            ->first();

        if($request->actionBtn == 'approve'){
            $approve->approval_required = 'APPROVE';
        }else{
            $approve->approval_required = 'REJECT';
        }
        if(!empty($approve)){
            $approve->save();
        }

        $approve_status = Approvaluser::join('approval_process', 'approvaluser.process_id', '=', 'approval_process.process_id')
            ->where('approve_id', $request->id_pr)
            ->where('process_name','PR')
            ->where('model','App/Models/Purchases')
            ->get();

        if(count($approve_status) == count($approve_status->where('approval_required', 'APPROVE'))){
            Purchases::where('id', $id)->update(['status' => 1]);


        }
        if(count($approve_status) == count($approve_status->where('approval_required', 'REJECT'))){
            Purchases::where('id', $id)->update(['status' => 2]);
        }

        Alert::success('Success', 'Status updated successfully');
        return redirect()->back();
    }
    public function generate_po(Request $request)
    {
        try {
            $purchases = Purchases::find($request->id);
            $purchaseBody = PurchaseBodies::where('purchase_id', $purchases->id)->get();
            $purchaseAdds = purchaseAdditional::where('purchase_id', $purchases->id)->first();
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => $request->po_number,
                'id_pr' => $request->id,
                'request_date' => $purchases->request_date,
                'required_date' => $purchases->required_date,
                'description' => $purchases->description,
                'total' => $purchases->total,
                'status' => 0,
                'business_id' => $purchases->business_id,
                'user_id' => $purchases->user_id,
            ]);

            if(!empty($purchaseBody)){
                foreach ($purchaseBody as $body){
                   $purchaseOrderBodies = PurchaseOrderBodies::create([
                       'purchase_id' => $purchaseOrder->id,
                       'part_id' => $body->part_id,
                       'qty' => $body->qty,
                       'unit_price' => $body->unit_price,
                       'total_price' => $body->total_price,
                       'tax' => $body->tax,
                       'model' => $body->model
                   ]);
                }
            }
            if(!empty($purchaseAdds)){
                $purchaseOrderAdditional = PurchaseOrderAdditional::create([
                    'purchase_id' => $purchaseOrder->id,
                    'account_id' => $purchaseAdds->account_id,
                    'charge_department' => $purchaseAdds->charge_department,
                    'wo_id' => $purchaseAdds->wo_id,
                    'facility_id' => $purchaseAdds->facility_id,
                    'asset_id' => $purchaseAdds->asset_id,
                    'impacted_production' => $purchaseAdds->impacted_production ?? false, // Atur default value
                ]);
            }

            Purchases::where('id', $request->id)->update(['sync' => 1]);

            $purchaseTotal = (float) $purchases->total; // Ubah ke float

            $approve = Approval_layers::join('approval_process', 'approval_layers.process_id', '=', 'approval_process.process_id')
                ->where('approval_process.process_name', 'PO')
                ->whereRaw('? BETWEEN approval_process.budget AND approval_process.max_budget', [$purchaseTotal])
                ->get();

            foreach ($approve as $key => $value) {
                Approvaluser::create([
                    'process_id' => $value->process_id,
                    'user_id' => $value->role_id,
                    'approval_required' => 'PENDING',
                    'approve_id' => $purchaseOrder->id,
                    'model' => 'App/Models/PurchaseOrder'
                ]);
            }

            Alert::success('Success', 'Purchase Order Generated Successfully');
            return redirect()->route('purchase_order.list');


        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }



    }
    public function getpurchase(Request $request)
    {
        $items = PurchaseOrderBodies::with([
            'getpurchaseorder.business',

            'part' => function ($query) {
                $query->select('*'); // Sesuaikan jika ingin memilih field tertentu
            },
            'equipment' => function ($query) {
                $query->select('*');
            },
            'tools' => function ($query) {
                $query->select('*');
            },
            'facility' => function ($query) {
                $query->select('*');
            }
        ])
            ->where('purchase_id', $request->po_ids)
            ->whereHas('getpurchaseorder', function ($query) {
                $query->where('status', 1);
            })
            ->get()
            ->map(function ($item) {
                // Hanya ambil relasi sesuai dengan model
                if ($item->model === 'part') {
                    $item->setRelation('equipment', null);
                    $item->setRelation('tools', null);
                    $item->setRelation('facility', null);
                } elseif ($item->model === 'equipment') {
                    $item->setRelation('part', null);
                    $item->setRelation('tools', null);
                    $item->setRelation('facility', null);
                } elseif ($item->model === 'tools') {
                    $item->setRelation('part', null);
                    $item->setRelation('equipment', null);
                    $item->setRelation('facility', null);
                } elseif ($item->model === 'facility') {
                    $item->setRelation('part', null);
                    $item->setRelation('equipment', null);
                    $item->setRelation('tools', null);
                }
                return $item;
            });

        return response()->json(['data' => $items]);
    }
    public function store_receipt(Request $request)
    {

        try {
            $receipt = Receipt::create([
                'po_number' => $request->po_number,
                'receipt_date' => $request->date_ordered,
                'receipt_number' => $request->code,
                'packing_slip' => $request->packing_slip,
                'no_jalan' =>  $request->surat_jalan,
                'business_id' => $request->supplier_id,
                'status' => 0,
                'total' => $request->total_price
            ]);
            $parts = $request->parts;
            $unitPrices = $request->unit_price;
            $receivedTo = $request->received_to;
            foreach ($parts as $index => $partId) {
                ReceiptBody::create([
                    'receipt_id' => $receipt->id,
                    'part_id' => $partId,
                    'received_to' => $receivedTo[$index],
                    'unit_price' => $unitPrices[$index],
                ]);
                $po_number = PurchaseOrder::with('purchaseOrderBodies')->where('id', $request->po_number)->first();



            }





            Alert::success('Success', 'Data added successfully');
            return redirect()->route('receipt.list');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }



    }
    public function getDataReceipt()
    {
        $receipts = Receipt::with([
            'receipt_body.part',
            'receipt_body.equipment',
            'receipt_body.tools',
            'receipt_body.facility',
            'business',
            'pos'
        ])->get();
        return DataTables::of($receipts)
            ->addColumn('no', function ($row) use (&$index) {
                return ++$index;
            })
            ->addColumn('po_number', fn($row) => $row->pos->po_number ?? '-')
            ->addColumn('supplier_name', fn($row) => $row->business->business_name ?? '-')
//                if status = 0 draft 1 approve 2 reject
            ->addColumn('status', fn($row) => $row->status == 0 ? 'Draft' : ($row->status == 1 ? 'Approve' : 'Reject'))
//            ->addColumn('site', fn($row) => $row->site->name ?? '-')
            ->addColumn('action', function ($row) {
                return '<a href="'.route('receipt.show', $row->id).'" class="btn btn-info btn-sm">View</a>';
            })
            ->addColumn('bodies', function ($row) {
                return $row->receipt_body->map(function ($body) {
                    // Determine the type of item and its name
                    if ($body->part) {
                        $itemType = 'part';
                        $itemName = $body->part->nameParts ?? '-';
                    } elseif ($body->equipment) {
                        $itemType = 'equipment';
                        $itemName = $body->equipment->name ?? '-';
                    } elseif ($body->tools) {
                        $itemType = 'tools';
                        $itemName = $body->tools->name ?? '-';
                    } elseif ($body->facility) {
                        $itemType = 'facility';
                        $itemName = $body->facility->name ?? '-';
                    } else {
                        $itemType = 'Unknown';
                        $itemName = '-';
                    }

                    return [
                        'item_type' => $itemType,
                        'item_name' => $itemName,
                        'received_to' => $body->received_to,
                        'unit_price' => $body->unit_price,
                    ];
                });

            })
            ->rawColumns(['action','supplier_name','po_number','bodies'])
            ->make(true);

    }
    public function show_receipt($id)
    {
        $receipt = Receipt::with([
            'receipt_body.part',
            'receipt_body.equipment',
            'receipt_body.tools',
            'receipt_body.facility',
            'business',
            'pos'
        ])
            ->find($id);

        return view('receipt.view', compact('receipt'));
    }

    public function edit($id)
    {
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get(); // Perbaikan kutip ganda
        $business = Business::latest()->get();
        $data = $part->merge($equipments)->merge($tools);
        $purchase = Purchases::with('business','purchaseAdditional.accounts','purchaseAdditional.charge_account','purchaseAdditional.wos','purchaseBodies.facility','purchaseBodies.equipment','purchaseBodies.tools','purchaseBodies.part')->find($id);
        $business = Business::latest()->get();
        $account = Account::latest()->get();
        $charge = ChargeDepartment::latest()->get();
        $facilities = Facility::with('children')->whereNull('parent_id')->latest()->get();

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
        })->values();
        $wo = Work_orders::latest()->get();

        return view('purchase.create', compact('purchase','business','account','charge','facilities','data','groupedData','wo'));
    }
    public function update(Request $request, $id)
    {
//        dd($request->all());
        try {
            $purchase = Purchases::findOrFail($id);

            if ($request->hasFile('supporting_documents')) {
                $data['doc'] = $request->file('supporting_documents')->store('purchase', 'public');
            } else {
                $data['doc'] = $purchase->doc; // Gunakan dokumen lama jika tidak diubah
            }

            // Update data utama purchase
            $purchase->update([
                'request_date' => $request->request_date,
                'required_date' => $request->required_date,
                'description' => $request->notes,
                'total' => $request->totalAmount,
                'doc' => $data['doc'],
                'business_id' => $request->business,
                'user_id' => auth()->user()->id
            ]);

            // Update atau create ulang purchaseAdditional
            $purchase->purchaseAdditional()->updateOrCreate(
                ['purchase_id' => $purchase->id],
                [
                    'account_id' => $request->account,
                    'charge_department' => $request->chargemanagement,
                    'wo_id' => $request->work_order,
                    'facility_id' => $request->ship_to_location,
                    'asset_id' => $request->impacted_asset,
                    'impacted_production' => $request->production_impact
                ]
            );

            // Hapus dulu item lama
            PurchaseBodies::where('purchase_id', $purchase->id)->delete();

            // Tambahkan ulang item
            for ($i = 0; $i < count($request->item_code); $i++) {
                PurchaseBodies::create([
                    'purchase_id' => $purchase->id,
                    'part_id' => $request->item_code[$i] == 'custom' ? $request->custom_item_name[$i] : $request->item_code[$i],
                    'qty' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'total_price' => $request->total_price[$i],
                    'model' => $request->model[$i]
                ]);
            }

            // Optional: Reset approval jika perlu
            Approvaluser::where('approve_id', $purchase->id)->delete();

            $purchaseTotal = (float) $purchase->total;

            $approve = Approval_layers::join('approval_process', 'approval_layers.process_id', '=', 'approval_process.process_id')
                ->where('approval_process.process_name', 'PR')
                ->whereRaw('? BETWEEN approval_process.budget AND approval_process.max_budget', [$purchaseTotal])
                ->get();

            foreach ($approve as $value) {
                Approvaluser::create([
                    'process_id' => $value->process_id,
                    'user_id' => $value->role_id,
                    'approval_required' => 'PENDING',
                    'approve_id' => $purchase->id,
                    'model' => 'App/Models/Purchases'
                ]);
            }

            Alert::success('Success', 'Purchase Request Updated Successfully');
            return redirect()->route('purchase.list');

        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->route('purchase.list');
        }
    }

}
