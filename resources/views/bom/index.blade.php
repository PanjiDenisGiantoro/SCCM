@extends('layout.layout')

@php
    $title = 'List BOM';
    $subTitle = 'List BOM';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('bom.create') }}" class="btn btn-outline-success btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th></th> <!-- Kolom untuk tombol expand -->
                        <th scope="col">Name</th>
                        <th scope="col">Total Part</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
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
            ajax: "{{ route('bom.getData') }}",
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '<button class="btn btn-sm btn-outline-success">➕</button>',
                },
                { data: 'name', name: 'name' },
                { data: 'total_assets', name: 'total_assets' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Toggle Child Row saat tombol diklik
        $('#dataTable tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                $(this).html('<button class="btn btn-sm btn-outline-success">➕</button>');
            } else {
                var bom_id = row.data().name; // Ambil ID bom
                $.ajax({
                    url: "{{ route('bom.getDataBom') }}", // pastikan route ini sudah ada
                    type: "GET",
                    data: { bom_id: bom_id },
                    success: function (data) {
                        console.log(data)
                        var childTable = '<table class="table table-sm">';
                        childTable += '<thead><tr><th>Part Name</th><th>Quantity</th></tr></thead><tbody>';
                        $.each(data, function (index, part) {
                            childTable += `<tr><td>${part.parts[0].nameParts}</td><td>${part.quantity}</td></tr>`;
                        });
                        childTable += '</tbody></table>';
                        row.child(childTable).show();
                        tr.find('td.dt-control').html('<button class="btn btn-sm btn-outline-danger">➖</button>');
                    }
                });
            }
        });

    });
</script>
