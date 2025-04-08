@extends('layout.layout2')

@php
    $title = 'Work Order Administration';
    $subTitle = 'Work Order Administration';
@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 0.85rem; /* Ukuran teks lebih kecil */
        }

        .card {
            padding: 0.5rem; /* Mengurangi padding card */
            margin-bottom: 0.5rem; /* Mengurangi margin antar card */
        }

        .card-header h6 {
            font-size: 0.9rem; /* Mengurangi ukuran header */
        }

        .form-group {
            margin-bottom: 0.5rem; /* Mengurangi spasi antar input */
        }

        .form-control, .form-select {
            font-size: 0.85rem; /* Mengurangi ukuran teks input & select */
            padding: 0.3rem 0.5rem; /* Mengurangi padding input */
        }

        button {
            font-size: 0.85rem; /* Mengurangi ukuran teks pada button */
            padding: 0.3rem 0.6rem; /* Mengurangi padding button */
        }
    </style>

    <style>
        span {
            display: inline;
        }
    </style>
    <div id="workcreate">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    {{  QrCode::size(100)->generate($wo->code) }}
                    <button type="button" class="btn btn-dark m-2">Back</button>
                    <div class="dropdown">
                        <button class="btn btn-outline-info dropdown-toggle m-2" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                            <li><button type="button" class="dropdown-item btn-outline-info rounded-2" id="submitRequest">Submit</button></li>
                            <li><a class="dropdown-item" href="#">Create Schedule</a></li>
                            <li><a class="dropdown-item" href="#">Submit Request for Approval</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>General Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Work Order Status</label>
                                    <select class="form-select select2" id="name" name="name">
                                        <option value="open" @if ($wo->work_order_status == 'open') selected @endif>Open</option>
                                        <option value="pending">Pending</option>
                                        <option value="progress">In Progress</option>
                                        <option value="complete">Completed</option>
                                        <option value="cancel">Cancelled</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Asset</label>
                                    <select class="form-control select2" name="asset_id">
                                        @foreach ($groupedData as $group)
                                            <optgroup label="{{ $group['text'] }}">
                                                @foreach ($group['children'] as $child)
                                                    <option value="{{ $child['id'] }}" data-type="{{ $group['text'] }}">
                                                        {{ $child['text'] }} ({{ $group['text'] }})</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Priority</label>
                                    <select class="form-select select2" id="name" name="priority">
                                        <option>Select Priority</option>
                                        <option value="3">High</option>
                                        <option value="2">Medium</option>
                                        <option value="1">Low</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="maintenance_type">Maintenance Type</label>
                                    <select class="form-select select2" id="maintenance_type" name="maintenance">
                                        <option>Select Maintenance Type</option>
                                        <option value="preventive" style="background-color: #2d61ae; color: white;">Preventive</option>
                                        <option value="damage" style="background-color: #cc4140; color: white;">Damage</option>
                                        <option value="corrective" style="background-color: #74bc50; color: white;">Corrective</option>
                                        <option value="safety" style="background-color: #FF9900; color: white;">Safety</option>
                                        <option value="upgrade" style="background-color: #6fae9c; color: white;">Upgrade</option>
                                        <option value="electrical" style="background-color: #d2ca4e; color: white;">Electrical</option>
                                        <option value="project" style="background-color: #967855; color: white;">Project</option>
                                        <option value="inspection" style="background-color: #638582; color: white;">Inspection</option>
                                        <option value="meter_reading" style="background-color: #7F7F7F; color: white;">Meter Reading</option>
                                        <option value="other" style="background-color: #d36e87; color: white;">Other</option>
                                        <option value="replacement" style="background-color: #FF4F90; color: white;">Replacement</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Project</label>
                                    <select class="form-select select2" id="project" name="project_id">
                                        <option>Select Project</option>
                                        <option value="1">Maintenance 1</option>
                                        <option value="2">Maintenance 2</option>
                                        <option value="3">Maintenance 3</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Suggested Start Date</label>
                                    <input type="date" class="form-control" id="sugges" name="suggest">
                                </div>
                                <div class="form-group">
                                    <label for="name">Suggested Completion Date</label>
                                    <input type="date" class="form-control" id="suggest_complete" name="suggest_complete" >
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6>User Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="assign">Assign To User</label>
                                    <select class="form-select select2" id="assign" name="assign">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }} - {{ $user->roles[0]->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="labor">Estimated Labor (hours)</label>
                                    <input type="text" class="form-control" id="labor" name="labor" value="4">
                                </div>
                                <div class="form-group">
                                    <label for="assign">Completed By User</label>
                                    <select class="form-select select2" id="assign_complete" name="assign_complete">
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }} - {{ $user->roles[0]->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="labor">Actual Labor (hours)</label>
                                    <input type="text" class="form-control" id="actual_labor" name="actual_labor" >
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true">General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completion-tab" data-bs-toggle="tab" data-bs-target="#completion"
                                type="button"
                                role="tab" aria-controls="completion" aria-selected="false">Completion <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts"
                                type="button" role="tab" aria-controls="parts" aria-selected="false">Parts
                            <span class="badge bg-gray-200 text-gray-700">2</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="labor-tab" data-bs-toggle="tab" data-bs-target="#labor"
                                type="button" role="tab" aria-controls="labor" aria-selected="false">Labor Task
                            <span class="badge bg-gray-200 text-gray-700">2</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="meterReading-tab" data-bs-toggle="tab" data-bs-target="#meterReading"
                                type="button" role="tab" aria-controls="meterReading" aria-selected="false">Meter Reading <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="miscCost-tab" data-bs-toggle="tab" data-bs-target="#miscCost"
                                type="button" role="tab" aria-controls="miscCost" aria-selected="false">Misc Cost Page <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>{{--                        warranties--}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notif-tab" data-bs-toggle="tab" data-bs-target="#notif"
                                type="button" role="tab" aria-controls="notif" aria-selected="false">Notification <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button"
                                role="tab" aria-controls="files" aria-selected="false">Files <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="purchased-tab" data-bs-toggle="tab" data-bs-target="#purchased" type="button"
                                role="tab" aria-controls="purchased" aria-selected="false">Purchase <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button"
                                role="tab" aria-controls="parent" aria-selected="false">Include Incident <span
                                class="badge bg-gray-200 text-gray-700">3</span></button>
                    </li>


                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button"
                                role="tab" aria-controls="log" aria-selected="false">Log <span
                                class="badge bg-gray-200 text-gray-700">6</span></button>
                    </li>
                </ul>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summary">Description</label>
                                        <textarea class="form-control" id="summary" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="problem_code">Problem Code</label>
                                        <select class="form-select select2" id="problem_code" name="problem_code">
                                            <option value="problem_1">Problem 1 – Kesalahan sistem</option>
                                            <option value="problem_2">Problem 2 – Gangguan jaringan</option>
                                            <option value="problem_3">Problem 3 – Kegagalan perangkat keras</option>
                                            <option value="problem_4">Problem 4 – Kesalahan konfigurasi</option>
                                            <option value="problem_5">Problem 5 – Permasalahan akses pengguna</option>
                                            <option value="problem_6">Problem 6 – Bug pada aplikasi</option>
                                            <option value="problem_7">Problem 7 – Data tidak sinkron</option>
                                            <option value="problem_8">Problem 8 – Koneksi database gagal</option>
                                            <option value="problem_9">Problem 9 – Overload server</option>
                                            <option value="problem_10">Problem 10 – Kesalahan input pengguna</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="workinstruction">Work Instruction</label>
                                        <textarea class="form-control" id="workinstruction" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="completion" role="tabpanel" aria-labelledby="completion-tab">
                        <div class="row m-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cost Tracking</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Account</label>
                                                    <input type="text" class="form-control" id="name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Change Department</label>
                                                    <input type="date" class="form-control" id="name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cause</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Cause </label>
                                                    <input type="text" class="form-control" id="name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Cause Code</label>
                                                    <input type="date" class="form-control" id="name" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Completion Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Action Code </label>
                                                    <input type="text" class="form-control" id="name" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Solution Code </label>
                                                    <input type="date" class="form-control" id="name">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Completion Notes</label>
                                                    <textarea class="form-control" id="name" rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Admin Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Admin Notes</label>
                                                    <textarea class="form-control" id="name" rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Parts" role="tabpanel" aria-labelledby="Parts-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Add Part</button>
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg">Add BOM Group</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>Part/Supply</th>
                                                <th>For the asset</th>
                                                <th>Suggested Quantity</th>
                                                <th>Actual Quantity Used</th>
                                                <th>Aisle</th>
                                                <th>Row</th>
                                                <th>Bin</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="meterReading" role="tabpanel" aria-labelledby="meterReading-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Add Part</button>
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg">Add BOM Group</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>For the Asset</th>
                                                <th>Last Reading</th>
                                                <th>Date Submmited</th>
                                                <th>Reading Added On This WO</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    Power Meter
                                                </td>
                                                <td>
                                                    1000
                                                </td>
                                                <td>
                                                    Sep 22, 2023 8:00 AM
                                                </td>
                                                <td></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane fade" id="miscCost" role="tabpanel" aria-labelledby="miscCost-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Misc Cost</button>
                                    </div>


                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Est Quantity</th>
                                                <th>Est Unit Cost</th>
                                                <th>Est Total Cost</th>
                                                <th>Quantity</th>
                                                <th>Actual Unit Cost</th>
                                                <th>Actual Total Cost</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notif" role="tabpanel" aria-labelledby="notif-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Misc Cost</button>
                                    </div>


                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>Technisian</th>
                                                <th>Notify On Assignment</th>
                                                <th>Notify On Status Change</th>
                                                <th>Notify On Completion</th>
                                                <th>Notify On Task Completed</th>
                                                <th>Notify On Online Offline</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Add File</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Preview</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                        <div class="row m-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>
                                                    User
                                                </th>
                                                <th>
                                                    Hours Taken
                                                </th>
                                                <th>
                                                    Inventory Cost
                                                </th>
                                                <th>
                                                    Completion Notes
                                                </th>
                                                <th>
                                                    Log Date
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="parent-tab">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Include Work Order</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="purchased" role="tabpanel" aria-labelledby="purchased-tab">
                        <div class="row m-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0 ">
                                            <thead>
                                            <tr>
                                                <th>Requested Item</th>
                                                <th>Description</th>
                                                <th>Req Qty</th>
                                                <th>Purchase Order</th>
                                                <th>Supplier</th>
                                                <th>Status</th>
                                                <th>Need By</th>
                                                <th>Qty Received</th>
                                                <th>Unit Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tambahkan di bagian head -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                dropdownParent: $('body') // Pastikan dropdown tidak berada dalam elemen tersembunyi
            });


        });
    </script>

    <script>
        $(document).ready(function () {
            $("#submitRequest").click(function () {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to submit this purchase request?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buat FormData untuk mengirimkan data
                        let formData = new FormData();

                        // Ambil semua input, select, dan textarea dalam #workcreate
                        $("#workcreate").find("input, select, textarea").each(function () {
                            let inputType = $(this).attr("type");
                            let inputName = $(this).attr("name");

                            // Jika input adalah file, ambil file-nya
                            if (inputType === "file") {
                                if ($(this)[0].files.length > 0) {
                                    formData.append(inputName, $(this)[0].files[0]);
                                }
                            } else {
                                formData.append(inputName, $(this).val());
                            }
                        });

                        // Debugging: Lihat data yang dikirim
                        for (let pair of formData.entries()) {
                            console.log(pair[0] + ": " + pair[1]);
                        }

                        $.ajax({
                            url: "{{ url('api/wo/store') }}", // Ganti dengan URL backend
                            type: "POST",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Your purchase request has been submitted.",
                                    icon: "success"
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Something went wrong. Please try again.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

