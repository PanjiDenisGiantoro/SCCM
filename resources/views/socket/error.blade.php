@extends('layout.layout2')

@php
    $title = 'Error Log';
    $subTitle = 'API Error Log Monitoring';
@endphp

@section('content')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">API Error Logs</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="errorLogTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Socket ID</th>
                                <th>Host</th>
                                <th>Port</th>
                                <th>Endpoint</th>
                                <th>Error Message</th>
                                <th>Last Occurrence</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($errorLogs as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->socket_id }}</td>
                                    <td>{{ $log->socket->host ?? '-' }}</td>
                                    <td>{{ $log->socket->port ?? '-' }}</td>
                                    <td>{{ $log->socket->endpoint ?? '-' }}</td>
                                    <td>{{ $log->message }}</td>
                                    <td>{{ $log->updated_at }}</td>
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
        $('#errorLogTable').DataTable();
    });
</script>
