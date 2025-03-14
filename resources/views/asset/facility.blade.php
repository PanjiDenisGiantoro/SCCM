@extends('layout.layout')

@php
    $title = 'List Facility';
    $subTitle = 'List Facility';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('asset.create') }}" class="btn btn-outline-success btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th></th> <!-- Kolom untuk Expand Child -->
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
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
        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('asset.getDataFacility') }}",
            columns: [
                {data: 'expand', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'description', name: 'description'},
                {data: 'status', name: 'status'},
                {data: 'action', orderable: false, searchable: false},
            ]
        });

        // Toggle child row
        $('#dataTable tbody').on('click', '.toggle-child', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                var facilityId = $(this).data('id');

                $.ajax({
                    url: "{{ route('asset.getDataFacility') }}",
                    data: {parent_id: facilityId},
                    success: function (data) {
                        var childTable = `<table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>`;

                        data.forEach(function (child) {
                            childTable += `<tr>
            <td>${child.name}</td>
            <td>${child.code}</td>
            <td>${child.description || '-'}</td>
            <td>
                <span class="badge ${child.status === '1' ? 'bg-success' : 'bg-danger'}">
                    ${child.status === '1' ? 'Active' : 'Inactive'}
                </span>
            </td>
        </tr>`;
                        });

                        childTable += `</tbody></table>`;

                        row.child(childTable).show();
                        tr.addClass('shown');
                    }
                });
            }
        });
    });

</script>
