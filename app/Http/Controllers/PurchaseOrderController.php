<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
use App\Models\Tools;
use App\Models\User;
use App\Models\Work_orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PurchaseOrderController extends Controller
{
    public function index()
    {

        return view('purchase_order.list');
    }

    public function getData()
    {
        $purchases = PurchaseOrder::with('purchases')->get();

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
            ->editColumn('no_pr', function ($purchase) {
                return  $purchase->purchases->no_pr ?? '';
            })
            ->addColumn('action', function ($purchase) {
                return '
    <div class="btn-group">
        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="' . route('purchase_order.show', $purchase->id) . '">View</a></li>
            <li><a class="dropdown-item" href="' . route('purchase_order.edit', $purchase->id) . '">Edit</a></li>
            <li>
                <form action="' . route('purchase_order.destroy', $purchase->id) . '" method="POST" onsubmit="return confirm(\'Are you sure?\');">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                </form>
            </li>
        </ul>
    </div>';
            })

            ->rawColumns(['status', 'action',' no_pr'])
            ->make(true);

    }
    public function show($id)
    {
        $purchase = PurchaseOrder::with([
            'purchaseBodies.part',
            'purchaseBodies.equipment',
            'purchaseBodies.tools',
            'purchaseBodies.facility',
        ])->find($id);
        $total = (int) $purchase->total;

        $approve = Approval_process::join('approval_layers', 'approval_process.process_id', '=', 'approval_layers.process_id')
            ->where('process_name','PO')
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
            ->where('process_name','PO')
            ->where('approve_id', $id)
            ->where('model','App/Models/PurchaseOrder')
            ->where('user_id',Auth::user()->id)->first();


        if(empty($approveuser)){
            $approveuser = null;
        }else{
            $approveuser = $approveuser;
        }

        $approve_user = Approvaluser::with('user')->join('approval_process', 'approvaluser.process_id', '=', 'approval_process.process_id')
            ->where('process_name','PO')
            ->where('approve_id', $id)
            ->where('model','App/Models/PurchaseOrder')
            ->where('budget','<',$total)
            ->where('max_budget','>=',$total)
            ->get();

        return view('purchase_order.detail',compact('purchase','business','clients','approve','approveuser','approve_user'));

    }

    public function approve($id,Request $request)
    {
//        dd($request->all());
        $approve  = Approvaluser::join('approval_process', 'approvaluser.process_id', '=', 'approval_process.process_id')
            ->where('process_name','PO')
            ->where('approve_id', $request->id_pr)
            ->where('approvaluser.user_id', Auth::user()->id)
            ->where('model','App/Models/PurchaseOrder')
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
            ->where('process_name','PO')
            ->where('model','App/Models/PurchaseOrder')
            ->get();

        if(count($approve_status) == count($approve_status->where('approval_required', 'APPROVE'))){
            PurchaseOrder::where('id', $id)->update(['status' => 1]);
        }
        if(count($approve_status) == count($approve_status->where('approval_required', 'REJECT'))){
            PurchaseOrder::where('id', $id)->update(['status' => 2]);
        }


        Alert::success('Success', 'Status updated successfully');
        return redirect()->back();
    }
    public function edit($id)
    {

        $purchase = PurchaseOrder::with('business','purchaseAdditional.accounts','purchaseAdditional.charge_account','purchaseAdditional.wos','purchaseBodies.facility','purchaseBodies.equipment','purchaseBodies.tools','purchaseBodies.part')->find($id);

        $puchaseAdd = PurchaseOrderAdditional::with('wos','charge_account')->where('purchase_id', $id)->first();
        $purchaseBody = PurchaseOrderBodies::where('purchase_id', $id)->get();
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get(); // Perbaikan kutip ganda
        $business = Business::latest()->get();
        $data = $part->merge($tools)->merge($equipments);
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
        return view('purchase_order.create',compact('business','account', 'charge', 'facilities','data','code','purchase','puchaseAdd','purchaseBody','wo','groupedData'));
    }
    public function view($id)
    {

        $purchase = PurchaseOrder::find($id);
        $puchaseAdd = PurchaseOrderAdditional::all();
        $purchaseBody = PurchaseOrderBodies::all();
        $facilities = Facility::select('id', 'name', DB::raw("'facility' as type"))->get();
        $tools = Tools::select('id', 'name', DB::raw("'tool' as type"))->get();
        $equipments = Equipment::select('id', 'name', DB::raw("'equipment' as type"))->get();
        $part = Part::select('id', DB::raw('"nameParts" as name'), DB::raw("'part' as type"))->get(); // Perbaikan kutip ganda
        $business = Business::latest()->get();
        $data = $part->merge($tools)->merge($equipments);
        $code = 'PR-' . date('Ymd') . '-' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $account = Account::latest()->get();
        $charge = ChargeDepartment::latest()->get();
        $facilities = Facility::with('children')->whereNull('parent_id')->latest()->get();

        return view('purchase_order.create',compact('business','account', 'charge', 'facilities','data','code','purchase','puchaseAdd','purchaseBody'));

    }
}
