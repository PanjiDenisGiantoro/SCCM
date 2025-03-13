@extends('layout.layout')

@php
    $title = 'List Asset';
    $subTitle = 'List Asset';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <iconify-icon icon="fa6-solid:square-plus" class="icon text-lg line-height-1"></iconify-icon>
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
                                    No
                                </label>
                            </div>
                        </th>
                        <th scope="col">Location</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Asset Status</th>
                        <th scope="col">Status</th>
                        <th scope="col">Note</th>
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
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create New Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-3">Choose the type of asset:</p>
                    <div class="d-flex justify-content-center gap-3">
                        <!-- Facility Button -->
                        <a href="{{ route('asset.create', ['type' => 'facility']) }}" class="btn btn-light border d-flex align-items-center">
                            <img src="https://cdn-icons-png.flaticon.com/128/8146/8146769.png"
                                 alt="Facility" class="me-2" width="24" height="24">
                            Facility
                        </a>

                        <!-- Equipment Button -->
                        <a href="{{ route('asset.create', ['type' => 'equipment']) }}" class="btn btn-light border d-flex align-items-center">
                            <img src="https://cdn-icons-png.flaticon.com/128/8146/8146771.png"
                                 alt="Equipment" class="me-2" width="24" height="24">
                            Equipment
                        </a>

                        <!-- Tools Button -->
                        <a href="{{ route('asset.create', ['type' => 'tools']) }}" class="btn btn-light border d-flex align-items-center">
                            <img src="https://cdn-icons-png.flaticon.com/128/8146/8146772.png"
                                 alt="Tools" class="me-2" width="24" height="24">
                            Tools
                        </a>
                    </div>
                </div>

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
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // Tambahkan opsi ini untuk responsivitas

            ajax: "{{ route('groups.getData') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

