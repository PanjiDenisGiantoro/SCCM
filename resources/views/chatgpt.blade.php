@extends('layout.layout2')

@php
    $title = 'chatgpt';
    $subTitle = 'chatgpt';
@endphp

@section('content')
    <div class="container">
        <h2>Test API Form</h2>
        <form id="testForm">
            @csrf
            <div class="form-group">
                <label for="prompt">Masukkan Prompt:</label>
                <input type="text" id="prompt" name="prompt" class="form-control" placeholder="Masukkan pertanyaan" required>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>

        <h3>Hasil:</h3>
        <pre id="response"></pre>
    </div>

    <script>
        document.getElementById("testForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah form reload halaman

            let formData = new FormData(this);

            fetch("{{ route('chat') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("response").innerText = JSON.stringify(data, null, 2);
                })
                .catch(error => console.error("Error:", error));
        });
    </script>
@endsection
