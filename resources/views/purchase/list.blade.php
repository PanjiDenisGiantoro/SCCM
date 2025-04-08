@extends('layout.layout')

@php
    $title = 'Purhcase Request';
    $subTitle = 'Purhcase Request';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('purchase.create') }}" class="btn btn-outline-info btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table id="dataTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Request</th>
                        <th>Request Date</th>
                        <th>Required Date</th>
                        <th>Description</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
@endsection
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // Tambahkan opsi ini untuk responsivitas

            ajax: "{{ route('purchase.getData') }}",
            columns: [
                {data: null, name: 'no', orderable: false, searchable: false}, // No urut
                {data: 'no_pr', name: 'no_pr'},
                {data: 'request_date', name: 'request_date'},
                {data: 'required_date', name: 'required_date'},
                {data: 'description', name: 'description'},
                {data: 'total', name: 'total'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(index + 1);
            }
        });
    });
</script>

