@extends('layout.layout')

@php
    $title = 'List Facility';
    $subTitle = 'List Facility';

@endphp

@section('content')
    <style>
        .child-row td {
            padding: 0 !important; /* Hapus padding bawaan */
        }

        .child-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .child-table th, .child-table td {
            padding: 8px;
            text-align: left;
            white-space: nowrap; /* Mencegah wrapping yang tidak diinginkan */
        }

        .child-table tr {
            display: table-row;
        }

        .child-row {
            background-color: #f9f9f9; /* Warna latar belakang child */
        }

    </style>
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
            columnDefs: [{
                targets: 0,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; // Nomor urut
                }
            }],
            columns: [
                {data: null, orderable: false, searchable: false}, // Kolom nomor urut
                {data: 'expand', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'description', name: 'description'},
                {data: 'status', name: 'status'},
                {data: 'action', orderable: false, searchable: false},
            ]
        });

        // Handle klik tombol expand child (Gunakan event delegation)
        $(document).on('click', '.toggle-child', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var facilityId = $(this).data('id');
            var button = $(this);

            if (tr.next().hasClass('child-row')) {
                // Jika child row sudah ada, toggle visibility saja
                tr.next().toggle();
                button.text(tr.next().is(':visible') ? '-' : '+');
            } else {
                // Jika belum ada, ambil data dari server
                $.ajax({
                    url: "{{ route('asset.getDataFacility') }}",
                    data: {parent_id: facilityId},
                    success: function (data) {
                        console.log("Child data loaded for facility ID:", facilityId, data);

                        if (data.length > 0) {
                            var childTable = generateChildTable(data, facilityId);
                            tr.after(childTable);
                            button.text('-');
                        } else {
                            alert('Tidak ada data child.');
                        }
                    },
                    error: function () {
                        alert('Gagal mengambil data anak.');
                    }
                });
            }
        });

        function generateChildTable(data, parentId) {
            var tableHtml = `<tr class="child-row">
    <td colspan="7"> <!-- Sesuaikan colspan karena menambah kolom -->
        <div style="padding-left: 30px;"> <!-- Tambahkan div wrapper agar lebih rapi -->
            <table class="table table-bordered child-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th></th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>`;

            data.forEach(function (child, index) {
                tableHtml += `<tr>
        <td>${index + 1}</td> <!-- Nomor urut untuk child -->
        <td>
            ${child.has_children ? `<button class="btn btn-outline-info btn-sm toggle-child" data-id="${child.id}">+</button>` : ''}
        </td>
        <td>${child.name}</td>
        <td>${child.code}</td>
        <td>${child.description || '-'}</td>
        <td>
            <span class="badge ${child.status === '1' ? 'bg-success' : 'bg-danger'}">
                ${child.status === '1' ? 'Active' : 'Inactive'}
            </span>
        </td>
        <td>
            <button class="btn btn-outline-info btn-sm editBtn" data-id="${child.id}">
                <iconify-icon icon="lucide:edit"></iconify-icon>
            </button>
            <button class="btn btn-outline-danger btn-sm deleteBtn" data-id="${child.id}">
                <iconify-icon icon="lucide:trash-2"></iconify-icon>
            </button>
        </td>
    </tr>`;
            });

            tableHtml += `</tbody></table></div></td></tr>`;
            return tableHtml;
        }


    });

</script>
