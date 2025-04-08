@extends('layout.layout')

@php
    $title = 'List Work Orders';
    $subTitle = 'List Work Orders';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('wo.create') }}" class="btn btn-info btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Assets</th>
                        <th>Assign Users</th>
                        <th>Status</th>
                        <th>Origin Work Order</th>
                        <th>Completed By Users</th>
                        <th>Time Estimated Hours</th>
                        <th>Time Spent Hours</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($workOrders as $workOrder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $workOrder->code }}</td>
                            <td>{{ $workOrder->description }}</td>
                            <td>{{ $workOrder->priority }}</td>
                            <td>{{ $workOrder->asset_id }}</td>
                            <td>{{ $workOrder->assign_from }}</td>
                            <td>{{ $workOrder->work_order_status }}</td>
                            <td>{{ $workOrder->work_order_date }}</td>
                            <td>{{ $workOrder->completed_date }}</td>
                            <td>{{ $workOrder->estimate_hours }} Hours</td>
                            <td>{{ $workOrder->actual_hours }} Hours</td>
                            <td>

                                <a href="{{ route('wo.show', $workOrder->id) }}" class="btn btn-info btn-sm">
                                    <iconify-icon icon="fa6-regular:eye" class="icon text-lg line-height-1"></iconify-icon>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
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
            $('#dataTable').DataTable();
        });

        function edit(id) {
            alert('Edit Work Order ID: ' + id);
        }

        function destroy(id) {
            if (confirm('Apakah Anda yakin ingin menghapus Work Order ini?')) {
                alert('Hapus Work Order ID: ' + id);
            }
        }
    </script>
