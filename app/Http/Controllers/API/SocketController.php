<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Socket;
use App\Models\SocketErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

}
