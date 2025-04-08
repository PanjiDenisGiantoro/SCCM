
@extends('layout.layout2')

@php
    $title = 'Whatsapp Config';
    $subTitle = 'Whatsapp Config';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card">
                <div class="card-header">
{{--                    between --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Verify Whatsapp</h5>
                        <a href="{{ url('wa/verify/'.$whatsapp->no_wa) }}" class="btn btn-outline-info">Pairing</a>
                    </div>
                </div>
                <div class="card-body text-center">
                    <img src="{{$whatsappaccount->qrBase64 ?? ''}}" alt="QR Code">
                    <p class="mt-3">Jika sudah berhasil scan, silahkan klik tombol untuk test kirim pesan</p>
                    <button class="btn btn-outline-info" onclick="sendMessage('{{ $whatsapp->no_wa }}')">Test Kirim Pesan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->


    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        function sendMessage(phoneNumber) {
            const url = `http://localhost:5001/message/send-text?session=${phoneNumber}&to=${phoneNumber}&text=testing`;

            fetch(url, {
                method: "GET"
            })
                .then(response => response.json())  // Ubah response ke JSON
                .then(data => {
                    if (data.status === "success") {
                        alert("Pesan berhasil dikirim!");
                    } else {
                        alert("Gagal mengirim pesan: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat mengirim pesan.");
                });
        }
    </script>
@endsection



