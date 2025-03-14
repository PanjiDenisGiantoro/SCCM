<?php

namespace App\Http\Controllers;

use App\Models\AlarmSensor;
use App\Models\Socket;
use App\Models\SocketErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class RestController extends Controller
{
    public function index()
    {
        $apis = Socket::all();
        return view('socket.index', compact('apis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'host' => 'required|string',
            'port' => 'required|string',
            'endpoint' => 'required|string',
            'methode' => 'required|string',
        ]);

        Socket::create([
            'host' => $request->host,
            'port' => $request->port,
            'endpoint' => $request->endpoint,
            'status' => $request->status ?? 0,
            'methode' => $request->methode,
            'post_data' => $request->post_data ?? null,
            'error_log' => $request->error_log ?? '-'

        ]);
        Alert::success('Success', 'API berhasil ditambahkan.');

        return redirect()->route('socket.list')->with('success', 'API berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $api = Socket::findOrFail($id);
        $apis = Socket::all();
        return view('socket.index', compact('api', 'apis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'host' => 'required|string',
            'port' => 'required|string',
            'endpoint' => 'required|string',
        ]);

        $api = Socket::findOrFail($id);
        $api->update([
            'host' => $request->host,
            'port' => $request->port,
            'endpoint' => $request->endpoint,
            'methode' => $request->methode,
            'status' => $request->status ?? 0,
            'post_data' => $request->post_data ?? null,
            'error_log' => $request->error_log ?? '-'

        ]);

        Alert::success('Success', 'API berhasil diperbarui.');

        return redirect()->route('socket.list')->with('success', 'API berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $api = Socket::findOrFail($id);
        $api->delete();
        Alert::success('Success', 'API berhasil dihapus.');

        return redirect()->route('socket.list')->with('success', 'API berhasil dihapus.');
    }

    public function test($id)
    {
        $api = null;
        $data = [];
        $isEdit = false;
        $existingData = null;

        if ($id) {
            $api = Socket::find($id);
            if (!$api) {
                return redirect()->route('api.index')->with('error', 'Data not found!');
            }

            $alarm = AlarmSensor::where('id_socket', $api->id)->first();
            if ($alarm) {
                $value = $alarm->json;
            }
            $isEdit = true;
            $existingData = json_decode($value, true); // Ambil data dari kolom `json`

            $url = "{$api->host}:{$api->port}/{$api->endpoint}";

            try {
                $response = Http::get($url);
                $data = $response->json();
            } catch (\Exception $e) {
                $data = ['error' => $e->getMessage()];
            }
        }

        return view('socket.test', compact('api', 'data', 'isEdit', 'existingData', 'value'));
    }


    public function show($socketId)
    {
        $socket = Socket::with('errorLogs')->find($socketId);

        return DataTables::of($socket->errorLogs)
            ->addColumn('created_at', function ($errorLog) {
                return $errorLog->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('message', function ($errorLog) {
                return $errorLog->message ?? '-';
            })
            ->rawColumns(['created_at', 'message'])
            ->make(true);
    }

    public function error()
    {
        $errorLogs = SocketErrorLog::with('socket')->orderBy('updated_at', 'desc')->get();
        return view('error_log', compact('errorLogs'));
    }

    public function store_alarm(Request $request)
    {
        $request->validate([
            'api_id' => 'required|integer',
            'readResults' => 'required|array',
        ]);

        // Ambil data dari request
        $apiId = $request->input('api_id');
        $readResults = $request->input('readResults');

        // Simpan data ke database
        foreach ($readResults as $result) {
            AlarmSensor::create([
                'id_socket' => $apiId,
                'json' => json_encode($result) // Simpan seluruh JSON tanpa value terpisah
            ]);
        }
        Alert::success('Success', 'Data berhasil disimpan.');
        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function getByValue(Request $request)
    {
        $value = $request->input('value'); // Ambil parameter value

        // Query JSONB untuk mencocokkan data
        $data = DB::table('alarm_sensors')
            ->whereRaw("jsonb @> ?", ['{"v": "' . $value . '"}'])
            ->get();

        return response()->json($data);
    }


    public function test1()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:1234/v1/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "model": "meta-llama-3.1-8b-instruct",
  "prompt": "Apakah yang dimaksud dengan API",
  "max_tokens": 1000
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt'); // Ambil input prompt dari form

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:1234/v1/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "model" => "meta-llama-3.1-8b-instruct",
                "prompt" => $prompt,
                "max_tokens" => 1000
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return response()->json(json_decode($response, true)); // Kembalikan sebagai JSON
    }
    public function chatgpt()
    {
        return view('chatgpt');

    }
}

