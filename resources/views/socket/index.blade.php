@extends('layout.layout2')

@php
    $title = 'API Control Management';
    $subTitle = 'IoT API Response Monitoring';
@endphp

@section('content')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">IoT API Response Monitoring</h6>
                </div>
                <div class="card-body">
                    <form action="{{ isset($api) ? route('socket.update', $api->id) : route('socket.store') }}" method="post" id="apiForm">
                        @csrf
                        @if(isset($api)) @method('PUT') @endif
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label">Host <span class="text-danger">*</span></label>
                                <input type="text" name="host" required class="form-control" value="{{ old('host', $api->host ?? '') }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Port <span class="text-danger">*</span></label>
                                <input type="text" name="port" required class="form-control" value="{{ old('port', $api->port ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Endpoint <span class="text-danger">*</span></label>
                                <input type="text" name="endpoint" required class="form-control" value="{{ old('endpoint', $api->endpoint ?? '') }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Method <span class="text-danger">*</span></label>
                                <select name="methode" class="form-control form-select">
                                    <option value="GET" {{ (isset($api) && $api->methode == 'GET') ? 'selected' : '' }}>GET</option>
                                    <option value="POST" {{ (isset($api) && $api->methode == 'POST') ? 'selected' : '' }}>POST</option>
                                </select>
                            </div>
                            <div class="col-md-12" id="postDataContainer" style="display: none;">
                                <label class="form-label">POST Data <span class="text-danger">*</span></label>
                                <textarea name="post_data" class="form-control">{{ old('post_data', $api->post_data ?? '') }}</textarea>
                                <small class="text-muted">Masukkan data dalam format JSON.</small>
                            </div>


                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="0" {{ (isset($api) && $api->status == 0) ? 'selected' : '' }}>Inactive</option>
                                    <option value="1" {{ (isset($api) && $api->status == 1) ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary">{{ isset($api) ? 'Update' : 'Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">API List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="apiTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Host</th>
                                <th>Port</th>
                                <th>Endpoint</th>
                                <th>Method</th> <!-- Kolom baru -->
                                <th>Status</th>
                                <th>Running Well</th>
                                <th>Error Log</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apis as $api)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $api->host }}</td>
                                    <td>{{ $api->port }}</td>
                                    <td>{{ $api->endpoint }}</td>
                                    <td>{{ $api->methode }}</td> <!-- Tampilkan metode -->
                                    <td>{{ $api->status == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <span id="status-{{ $api->id }}" class="badge {{ $api->running_well ? 'bg-success' : 'bg-danger' }}">
                                            {{ $api->running_well ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td id="error-{{ $api->id }}">{{ $api->error_log ?? '-' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('socket.edit', $api->id) }}">Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="{{ url('socket/delete/'.$api->id) }}">Delete</a></li>
                                                <li><a class="dropdown-item" href="{{ route('socket.test', ['id' => $api->id]) }}">Test Ping</a></li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#apiTable').DataTable();
    });
</script>
<script src="https://cdn.socket.io/4.0.1/socket.io.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const socket = io("http://localhost:3009");

        socket.on("data-update", function (apiList) {
            apiList.forEach(api => {
                let statusElement = document.getElementById(`status-${api.id}`);
                let errorElement = document.getElementById(`error-${api.id}`);

                if (statusElement) {
                    statusElement.textContent = api.running ? "Running" : "Down";
                    statusElement.className = `badge bg-${api.running ? 'success' : 'danger'}`;
                }

                if (errorElement) {
                    if (errorElement.textContent !== api.error_log) { // Cek jika error log berubah
                        errorElement.textContent = api.error_log ? api.error_log : "-";
                        errorElement.className = api.error_log ? "text-danger" : "";

                        // Kirim permintaan AJAX ke server untuk update database
                        fetch("{{ route('api.updateErrorLog') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: api.id,
                                error_log: api.error_log
                            })
                        })
                            .then(response => response.json())
                            .then(data => console.log("Error log updated:", data))
                            .catch(error => console.error("Error updating log:", error));
                    }
                }
            });
        });

    });

</script>

<script>
    function checkApiStatus() {
        fetch('http://localhost:3009/api/read-tag')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(api => {
                        let statusElement = document.getElementById(`status-${api.id}`);
                        let errorElement = document.getElementById(`error-${api.id}`);

                        if (statusElement) {
                            statusElement.textContent = api.running ? "Running" : "Down";
                            statusElement.className = `badge bg-${api.running ? 'success' : 'danger'}`;
                        }
                        if (errorElement) {
                            errorElement.textContent = api.error_log ? api.error_log : "-";
                        }
                    });
                }
            })
            .catch(error => {
                console.error("Error fetching API status:", error);
            });
    }

    document.addEventListener("DOMContentLoaded", () => {
        checkApiStatus();
        setInterval(checkApiStatus, 10000);
    });


    document.addEventListener("DOMContentLoaded", () => {
        checkApiStatus();
        setInterval(checkApiStatus, 10000);
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const methodSelect = document.querySelector('select[name="methode"]');
        const postDataContainer = document.getElementById("postDataContainer");

        function togglePostData() {
            if (methodSelect.value === "POST") {
                postDataContainer.style.display = "block";
            } else {
                postDataContainer.style.display = "none";
            }
        }

        methodSelect.addEventListener("change", togglePostData);
        togglePostData(); // Panggil saat halaman dimuat
    });
</script>
