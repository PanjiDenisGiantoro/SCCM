<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function index()
    {
        $clientmax = Client::latest()->first();
        if($clientmax == null){
            $numberCode = 'C-'.Str::random(8);
        }else{
            $numberCode = 'C-'.($clientmax->id+1);
        }
        return view('client.index',compact('numberCode'));

    }
    public function store(Request $request)
    {

        try {

            $photoPath = null;
            if ($request->hasFile('logo')) {
                $photoPath = $request->file('logo')->store('logo', 'public');
            }

            $user = User::create([
                'name' => $request->nameClient,
                'email' => $request->emailClient,
                'password' => bcrypt('12345678'),
            ]);
            $client = Client::create([
                'nameClient' => $request->nameClient,
                'emailClient' => $request->emailClient,
                'dateClient' => $request->dateClient,
                'phoneClient' => $request->phoneClient,
                'lifetime' => $request->lifetime,
                'statusClient' => $request->statusClient,
                'typeClient' => $request->typeClient,
                'addressClient' => $request->addressClient,
                'codeClient' => $request->codeClient,
                'license' => 'l-alfasolutions-'.Str::random(8),
                'id_user' => $user->id,
                'logo' => $photoPath
            ]);

            $user->assignRole('admin');
            $user->update([
                'created_user' =>$client->id
            ]);

            activity()
                ->causedBy(Auth::user())
                ->log('Create Client');

           Alert::success('Success', 'Client created successfully');
            return redirect()->route('client.list');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());

            activity()
                ->causedBy(Auth::user())
                ->log('Create Client Gagal');
//            Alert::error('Error', 'Check your input');
            Log::error($e->getMessage());

            return redirect()->back();
        }

    }
    public function list()
    {
        return view('client.list');
    }
    public function edit($id){
        $data = Client::find($id);
        return view('client.index', compact('data'));
    }
    public function getData(){
        $clients = Client::select(['id', 'nameClient', 'emailClient', 'lifetime', 'statusClient'])->orderBy('id', 'desc');

        return DataTables::of($clients)
            ->editColumn('statusClient', function ($client) {
                if ($client->statusClient == 1) {
                    return '
                    <a href="'.route('client.status', $client->id).'"><button class="btn btn-success">Active</button></a>';

                } else {
                    return '
                    <a href="'.route('client.status', $client->id).'"><button class="btn btn-danger">Inactive</button></a>';
                }
            })
            ->editColumn('lifetime', function ($client) {
              return $client->lifetime . ' Year';
            })
            ->addColumn('action', function ($client) {
                $editUrl = route('client.edit', $client->id);
                $show = route('client.show', $client->id);
                return '
                    <a href="'.$show.'" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                    </a>
                   <a href="' . $editUrl . '" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
            <iconify-icon icon="lucide:edit"></iconify-icon>
        </a>';
            })
            ->rawColumns(['action','statusClient']) // Agar HTML di kolom action tidak di-escape
            ->make(true);
    }
    public function update(Request $request,$id){

        try {


            $photopath = null;
            if ($request->hasFile('logo')) {
                $photopath = $request->file('logo')->store('logo', 'public');
            }

            $client = Client::find($id);
            $client->nameClient = $request->nameClient;
            $client->emailClient = $request->emailClient;
            $client->dateClient = $request->dateClient;
            $client->phoneClient = $request->phoneClient;
            $client->addressClient = $request->addressClient;
            $client->lifetime = $request->lifetime;
            $client->statusClient = $request->statusClient;
            $client->save();

            $oldPhotoPath = public_path('storage/logo/' . $client->logo);
            if (!empty($client->logo) && file_exists($oldPhotoPath) && is_file($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            if (!empty($photopath)) {
                $client->logo = $photopath;
                $client->save();
            }
            $user = User::find($client->id_user);
            $user->name = $request->nameClient;
            $user->email = $request->emailClient;
            $user->save();

            activity()
                ->causedBy(Auth::user())
                ->log('Update Client');
            Alert::success('Success', 'Client updated successfully');
            return redirect()->route('client.list');
        }catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());

            activity()
                ->causedBy(Auth::user())
                ->log('Update Client Gagal');
//            Alert::error('Error', 'Check your input');
            Log::error($e->getMessage());

            return redirect()->back();

        }

    }
    public function show($id)
    {
        $data = Client::find($id);
        $disable = true;
        return view('client.index', compact('data', 'disable'));

    }
    public function status($id){
        $data = Client::find($id);
        if($data->statusClient == 1){
            $data->statusClient = 0;
            $data->save();
            activity()
                ->causedBy(Auth::user())
                ->log('Inactive Client');
            Alert::success('Success', 'Client Inactive successfully');
            return redirect()->route('client.list');
        }else{
            $data->statusClient = 1;
            $data->save();
            activity()
                ->causedBy(Auth::user())
                ->log('Active Client');
            Alert::success('Success', 'Client Active successfully');
            return redirect()->route('client.list');
        }
    }
}
