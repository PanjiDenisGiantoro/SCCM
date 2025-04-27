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
        $apis = Socket::with('alarms')->where('status', 1)->get();
        return response()->json($apis);
    }

    public function updateRunningStatus(Request $request)
    {

        $api = Socket::with('alarms')->find($request->id);

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
//        return $request->all();
        $api = Socket::with('alarms')->find($request->id);
        if (!$api) {
            return response()->json(['success' => false, 'message' => 'API not found'], 404);
        }

        if(!empty($request->value && !empty($request->alarms))){
            if(floatval($request->value) > floatval($request->alarms)){
                Log::info('data : '.$request->value.'> data2 :'.$request->alarms);
                DB::table('sensor_data')->create([
                    'name'=> $api->name,
                    'value' => $request->value,
                    'node_od'  => '0',
                    'status_alarm' => 0,
                    'count_over_temp' => 0
                ]);

                $this->sendWhatsAppMessage('6289522900800', 'Alarm! Sensor '.$request->name.' mendeteksi suhu '.$request->value.'°C pada default alarm value '.$request->alarms.'°C.');


            }
        }
        if(!empty($api->error_log)){
            $api->error_log = $request->error_log;
            $api->save();
            $socketlog = SocketErrorLog::create([
                'socket_id' => $api->id,
                'error_message' => $request->error_log
            ]);
            return response()->json(['success' => true, 'message' => 'Error log updated']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error log not found'], 404);
        }
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
        $dataArray = $request->input('data'); // Assuming 'data' is the key holding the array of records

        foreach ($dataArray as $data) {
            Log::info('Data dari ESP8266:', $data);

            sensor_motor::create([
                'suhu' => $data['temperature'] ?? 0,
                'listrik' => $data['voltage'],
                'vibrasi' => $data['vibration'],
                'rpm' => $data['rpm'],
                'axis' => $data['axis'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $dataArray
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
    public function testingdata(Request $request)
    {
        $data = $request->only(['rpm', 'temperature', 'vibration', 'voltage','axis']);

        Log::info('Data dari ESP8266 baru:', $data);

        // Ubah nama field ke format Laravel-mu
//        $data = [
//            'rpm' => floatval($data['rpm'] ?? 0),
//            'temperature' => floatval($data['temperature'] ?? 0),
//            'vibration' => floatval($data['vibration'] ?? 0),
//            'voltage' => floatval($data['voltage'] ?? 0),
//        ];

        // Cek jika ada salah satu nilai yang lebih dari 0.01
        sensor_motor::create([
            'suhu' => $data['temperature'] ?? 0,
            'listrik' => $data['voltage'],
            'vibrasi' => $data['vibration'],
            'rpm' => $data['rpm'],
            'axis' => $data['axis'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => $data
        ], 200);

    }


}
