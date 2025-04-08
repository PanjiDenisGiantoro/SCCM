<?php

namespace App\Http\Controllers;

use App\Models\whatsapp;
use App\Models\WhatsappAccount;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WhatsappController extends Controller
{
    public function index()
    {
        $whatsapp = whatsapp::all();
        return view('whatsapp.index',compact('whatsapp'));
    }
    public function store(Request $request)
    {
//        dd($request->all());

        $whatsapp = whatsapp::create([
            'host' => $request->name,
            'no_wa' => $request->no_wa,
            'status' => $request->status ?? 0,
        ]);

        if ($whatsapp) {
            Alert::success('Success', 'Data added successfully');
        }else{
            Alert::error('Error', 'Data not added successfully');
        }

        return redirect()->back();

    }
    public function viewVerify($id){
        $whatsapp = Whatsapp::find($id);
        return view('whatsapp.verify',compact('whatsapp'));
    }
    public function verify($id)
    {
        $whatsapp = Whatsapp::where('no_wa', $id)->first();
        $qrUrl = "http://localhost:5001/session/start?session=" . urlencode($whatsapp->no_wa);

        // Gunakan cURL untuk mengambil response
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $qrUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10, // Timeout 10 detik
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $qrResponse = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 400 || empty($qrResponse)) {
            // Jika request gagal, lakukan logout dan restart session
            $logoutUrl = "http://localhost:5001/session/logout?session=" . urlencode($whatsapp->no_wa);
            file_get_contents($logoutUrl); // Logout session lama

            // Coba restart session lagi
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $qrUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            ));
            $qrResponse = curl_exec($curl);
            curl_close($curl);
        }



        $qrData = json_decode($qrResponse, true);

        if (isset($qrData['qrBase64'])) {
            $qrBase64 = $qrData['qrBase64'];
        } else {
            Alert::error('Error', 'Data not found');
            return redirect()->back();
        }
        $qrdata = WhatsappAccount::where('no_wa', $whatsapp->no_wa)->first();

        if (!$qrdata) {
            $qrdata = WhatsappAccount::create([
                'no_wa' => $whatsapp->no_wa,
                'status' => 1,
                'qrBase64' => $qrBase64
            ]);
        }else{
            $qrdata->update([
                'status' => 1,
                'qrBase64' => $qrBase64
            ]);
        }

        $whatsappaccount = WhatsappAccount::where('no_wa', $whatsapp->no_wa)->first();
        return view('whatsapp.verify', compact('whatsapp', 'qrBase64','whatsappaccount'));
    }

    public function update(Request $request, $id)
    {
        $whatsapp = whatsapp::find($id);
        $whatsapp->no_wa = $request->no_wa;
        $whatsapp->save();
        Alert::success('Success', 'Data updated successfully');
        return redirect()->back();
    }
    public function startSession($no)
    {
        $phoneNumber = $no;
        if (!$phoneNumber) {
            return response()->json(['error' => 'Nomor WhatsApp diperlukan'], 400);
        }
        $honoApiUrl = "http://localhost:5001/session/start?session=" . urlencode($phoneNumber);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $honoApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($response, true));
    }

    public function test($no,$ms){
        $url = "http://localhost:5001/message/send-text?session=$no&to=$no&text=$ms";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);
        return $response;

        Alert::success('Success', 'Message sent successfully');
        return redirect()->back();
    }
    private function sendWhatsAppMessage($phoneNumber, $message)
    {
        $url = "http://localhost:5001/message/send-text?session=$phoneNumber&to=$phoneNumber&text=$message";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        return $response;

    }


}
