<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\sensor_motor;
use App\Models\Socket;
use App\Models\SocketErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocketController extends Controller
{
    public function getData()
    {
        $apis = Socket::where('status', 1)->get();
        return response()->json($apis);
    }

    public function updateRunningStatus(Request $request)
    {
        $api = Socket::find($request->id);
        if ($api) {
            $api->running_well = $request->running_well;
            $api->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'API not found'], 404);
    }

    public function updateSocket(Request $request)
    {
        $socket = Socket::find($request->id);
        if ($socket) {
            $socket->update([
                'status' => $request->status,
                'error_log' => $request->error_log, // Tetap update error terbaru
            ]);

            if (!empty($request->error_log)) {
                SocketErrorLog::create([
                    'socket_id' => $socket->id,
                    'error_message' => $request->error_log,
                ]);
            }
        }

    }

    public function store(Request $request)
    {
        SocketErrorLog::create([
            'socket_id' => $request->socket_id,
            'error_message' => $request->error_message,
        ]);

        return response()->json(['message' => 'Error log saved successfully'], 200);
    }

    public function updateErrorLog(Request $request)
    {
        $api = Socket::find($request->id);
        if (!$api) {
            return response()->json(['success' => false, 'message' => 'API not found'], 404);
        }
        $api->error_log = $request->error_log;
        $api->save();
            $socketlog = SocketErrorLog::create([
                'socket_id' => $api->id,
                'error_message' => $request->error_log
            ]);
        return response()->json(['success' => true, 'message' => 'Error log updated']);
    }
    public function rand(Request $request)
    {
        $data = $request->json()->all();

        // Log untuk debugging
        Log::info('Data dari ESP8266:', $data);

        DB::table('sensor_data')->create([
            'name'=> 'test',
            'value' => $data['temp'],
            'node_od'  => '0',
            'status_alarm' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $data
        ], 200);

    }
    public function sensor(Request $request)
    {
        // Ambil data dari request query (bukan JSON)
        $data = $request->only(['rpm', 'suhu', 'vibration', 'tegangan']);

        Log::info('Data dari ESP8266:', $data);

        // Ubah nama field ke format Laravel-mu
        $data = [
            'rpm' => floatval($data['rpm'] ?? 0),
            'temperature' => floatval($data['temperature'] ?? 0),
            'vibration' => floatval($data['vibration'] ?? 0),
            'voltage' => floatval($data['voltage'] ?? 0),
        ];

        // Cek jika ada salah satu nilai yang lebih dari 0.01
            sensor_motor::create([
                'listrik' => $data['voltage'],
                'suhu' => $data['temperature'],
                'vibrasi' => $data['vibration'],
                'rpm' => $data['rpm'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data received successfully',
                'data' => $data
            ], 200);


    }
    public function getdatacsv()
    {
        $data = sensor_motor::latest()->get();

        // Nama file CSV yang akan di-download
        $fileName = 'sensor_data_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // Header CSV
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        // Membuka output stream
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Menulis header kolom
            fputcsv($file, ['ID', 'Listrik (V)', 'Suhu (°C)', 'Vibrasi', 'RPM', 'Tanggal']);

            // Menulis data ke dalam CSV
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->listrik,
                    $row->suhu,
                    $row->vibrasi,
                    $row->rpm,
                    $row->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


}
