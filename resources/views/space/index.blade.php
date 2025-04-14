@extends('layout.layout2')

@php
    $title = 'Space & Occupancy List';
    $subTitle = 'Space & Occupancy List';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('space.create') }}" class="btn btn-outline-info btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th>Space ID</th>
                        <th>Building/Floor</th>
                        <th>Room Name/Number</th>
                        <th>Purpose</th>
                        <th>Area Size (m²)</th>
                        <th>Capacity</th>
                        <th>Occupancy Rate (%)</th>
                        <th>Status</th>
                        <th>Tenant/Department</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($occupancy as $item)
                        <tr>
                            <td>{{ $item->space_id }}</td>
                            <td>{{ $item->building_ref }}/{{ $item->floor ?? '-' }}</td>
                            <td>{{ $item->room_name }}</td>
                            <td>{{ $item->purpose }}</td>
                            <td>{{ $item->area_size }}</td>
                            <td>{{ $item->capacity }}</td>
                            <td>{{ $item->occupancy_rate }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->tenant_name }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
                            <td>
                                <a href="{{ route('space.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('space.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                responsive: true
            });
        });
    </script>
@endpush
