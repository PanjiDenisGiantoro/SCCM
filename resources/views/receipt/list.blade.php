@extends('layout.layout')

@php
    $title = 'Receipt';
    $subTitle = 'Receipt';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('receipt.create') }}" class="btn btn-outline-info btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th scope="col">

                            <div class="form-check style-check d-flex align-items-center">
                                <label class="form-check-label">
                                    +
                                </label>
                            </div>
                        </th>
                        <th scope="col">No</th>


                        <th scope="col">Code</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Status</th>
                        <th scope="col">Purchase Order</th>
                        <th scope="col">Date Received</th>
                        <th scope="col">No Surat Jalan</th>
                        <th scope="col">Packing Slip</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
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
        function format(d) {
            // Parse the bodies data to ensure it's an array
            var bodies = JSON.parse(d.bodies);
            let rows = '';
            bodies.forEach(function (item, index) {
                rows += `
                <tr>
                    <td>${index + 1}</td>
                        <td>${item.item_name}</td>
                    <td>${item.received_to}</td>
                    <td>${item.unit_price}</td>
                </tr>
            `;
            });

            return `
            <table class="table table-bordered mb-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Part</th>
                        <th>Received To</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        `;
        }

        const table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('receipt.getData') }}",
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                { data: 'no' },
                { data: 'receipt_number' },
                { data: 'supplier_name' },
                { data: 'status' },
                { data: 'po_number' },
                { data: 'receipt_date' },
                { data: 'no_jalan' },
                { data: 'packing_slip' },
                { data: 'action', orderable: false }
            ],
            order: [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#dataTable tbody').on('click', 'td.dt-control', function () {
            const tr = $(this).closest('tr');
            const row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });
</script>
