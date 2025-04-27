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
                    <button type="button" class="btn btn-dark m-2">Back</button>
                    <div class="dropdown">
                        <button class="btn btn-outline-info dropdown-toggle m-2" type="button" id="actionDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                            <li>
                                <button type="button" class="dropdown-item btn-outline-info rounded-2"
                                        id="submitRequest">Submit
                                </button>
                            </li>
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
                                        <option value="open">Open</option>
                                        <option value="pending">Pending</option>
                                        <option value="progress">In Progress</option>
                                        <option value="complete">Completed</option>
                                        <option value="cancel">Cancelled</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Asset</label>
                                    <select class="form-control select2" name="asset_id">
                                        <option value="">Select Asset</option>
                                        @foreach ($groupedData as $group)
                                            <optgroup label="{{ $group['text'] }}">
                                                @foreach ($group['children'] as $child)
                                                    <option value="{{ $child['id'] }}" data-type="{{ $group['text'] }}">
                                                        {{ $child['text'] }} ({{ $group['text'] }})
                                                    </option>
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
                                        <option value="preventive" style="background-color: #2d61ae; color: white;">
                                            Preventive
                                        </option>
                                        <option value="damage" style="background-color: #cc4140; color: white;">Damage
                                        </option>
                                        <option value="corrective" style="background-color: #74bc50; color: white;">
                                            Corrective
                                        </option>
                                        <option value="safety" style="background-color: #FF9900; color: white;">Safety
                                        </option>
                                        <option value="upgrade" style="background-color: #6fae9c; color: white;">
                                            Upgrade
                                        </option>
                                        <option value="electrical" style="background-color: #d2ca4e; color: white;">
                                            Electrical
                                        </option>
                                        <option value="project" style="background-color: #967855; color: white;">
                                            Project
                                        </option>
                                        <option value="inspection" style="background-color: #638582; color: white;">
                                            Inspection
                                        </option>
                                        <option value="meter_reading" style="background-color: #7F7F7F; color: white;">
                                            Meter Reading
                                        </option>
                                        <option value="other" style="background-color: #d36e87; color: white;">Other
                                        </option>
                                        <option value="replacement" style="background-color: #FF4F90; color: white;">
                                            Replacement
                                        </option>
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
                                    <input type="date" class="form-control" id="suggest_complete"
                                           name="suggest_complete">
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
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}
                                                - {{ $user->roles[0]->name ?? '' }}</option>
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
                                        <option value="">Select User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['name'] }}
                                                - {{ $user->roles[0]->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="labor">Actual Labor (hours)</label>
                                    <input type="text" class="form-control" id="actual_labor" name="actual_labor">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <ul class="nav nav-tabs mb-4 bg-body-secondary" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                                type="button" role="tab" aria-controls="general" aria-selected="true">General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completion-tab" data-bs-toggle="tab" data-bs-target="#completion"
                                type="button"
                                role="tab" aria-controls="completion" aria-selected="false">Completion
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts"
                                type="button" role="tab" aria-controls="parts" aria-selected="false">Parts
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="labors-tab" data-bs-toggle="tab" data-bs-target="#labors"
                                type="button" role="tab" aria-controls="labors" aria-selected="false">Labor Task
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="misc-tab" data-bs-toggle="tab" data-bs-target="#misc"
                                type="button" role="tab" aria-controls="misc" aria-selected="false">Misc. Costs Page
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="meterReading-tab" data-bs-toggle="tab"
                                data-bs-target="#meterReading"
                                type="button" role="tab" aria-controls="meterReading" aria-selected="false">Meter
                            Reading
                        </button>
                    </li>
                    {{--                    <li class="nav-item" role="presentation">--}}
                    {{--                        <button class="nav-link" id="miscCost-tab" data-bs-toggle="tab" data-bs-target="#miscCost"--}}
                    {{--                                type="button" role="tab" aria-controls="miscCost" aria-selected="false">Misc Cost Page--}}
                    {{--                            <span--}}
                    {{--                                class="badge bg-gray-200 text-gray-700">3</span></button>--}}
                    {{--                    </li>--}}
                    {{--                    <li class="nav-item" role="presentation">--}}
                    {{--                        <button class="nav-link" id="notif-tab" data-bs-toggle="tab" data-bs-target="#notif"--}}
                    {{--                                type="button" role="tab" aria-controls="notif" aria-selected="false">Notification <span--}}
                    {{--                                class="badge bg-gray-200 text-gray-700">3</span></button>--}}
                    {{--                    </li>--}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files"
                                type="button"
                                role="tab" aria-controls="files" aria-selected="false">Files
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="purchased-tab" data-bs-toggle="tab" data-bs-target="#purchased"
                                type="button"
                                role="tab" aria-controls="purchased" aria-selected="false">Purchase
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent"
                                type="button"
                                role="tab" aria-controls="parent" aria-selected="false">Include Incident
                        </button>
                    </li>


                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button"
                                role="tab" aria-controls="log" aria-selected="false">Log
                        </button>
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
                                        <textarea class="form-control" id="summary" name="description"
                                                  rows="3"></textarea>
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cost Tracking</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Account</label>
                                                    <select class="form-select select2" id="name" name="account">
                                                        <option></option>
                                                        @foreach ($account as $acc)
                                                            <option value="{{ $acc['id'] }}">{{ $acc['name'] }}
                                                                - {{ $acc['description'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Change Department</label>
                                                    <select class="form-select select2" id="charge"
                                                            name="change_department">
                                                        <option></option>
                                                        @foreach ($charge_account as $dep)
                                                            <option value="{{ $dep['id'] }}">{{ $dep['name'] }}
                                                                - {{ $dep['description'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Completion Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="action">Action Code</label>
                                                    <select class="form-select select2" id="action" name="action_code"
                                                            onchange="updateActionCode()">
                                                        <option value="" selected disabled>Pilih Action</option>
                                                        <option value="action_1">Action 1 – Restart sistem</option>
                                                        <option value="action_2">Action 2 – Reset konfigurasi</option>
                                                        <option value="action_3">Action 3 – Perbaikan perangkat keras
                                                        </option>
                                                        <option value="action_4">Action 4 – Update software</option>
                                                        <option value="action_5">Action 5 – Perbaikan jaringan</option>
                                                        <option value="action_6">Action 6 – Restore database</option>
                                                        <option value="action_7">Action 7 – Optimasi server</option>
                                                        <option value="action_8">Action 8 – Validasi ulang data</option>
                                                        <option value="action_9">Action 9 – Training pengguna</option>
                                                        <option value="action_10">Action 10 – Troubleshooting manual
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="action_code">Action Code</label>
                                                    <input type="text" class="form-control" name="action_code"
                                                           id="action_code" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Completion Notes</label>
                                                    <textarea class="form-control" id="completion" rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Admin Notes</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Admin Notes</label>
                                                    <textarea class="form-control" id="name" name="admin_note"
                                                              rows="3"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="labors" role="tabpanel" aria-labelledby="labors-tab">
                        <div class="row m-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Work Order Task</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="task">Choose Task Type</label>
                                                <select class="form-select select2" id="task_type" name="task_type">
                                                    <option>Pilih Task</option>
                                                    <option value="general">General</option>
                                                    <option value="text">Text</option>
                                                    <option value="meter_reading">Meter Reading</option>
                                                    <option value="inspection">Inspection</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Desctiption</label>
                                                <textarea class="form-control" id="task_deskription"
                                                          name="task_deskription"
                                                          rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="labor_assign">Assign To User</label>
                                                <select class="form-select select2" id="labor_assign"
                                                        name="labor_assign">
                                                    <option>Select User</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}
                                                            - {{$user->roles[0]->name ?? ''}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Start Date</label>
                                                <input type="date" class="form-control" id="task_start_date"
                                                       name="task_start_date">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Time Estimate (Hours)</label>
                                                <input type="date" class="form-control" id="task_time_estimate"
                                                       name="task_time_estimate">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Completed By User</label>
                                                <select class="form-select select2" id="task_assign_complete"
                                                        name="task_assign_complete">

                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}
                                                            - {{$user->roles[0]->name ?? ''}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Completion Date</label>
                                                <input type="date" class="form-control" id="task_completion_date"
                                                       name="task_completion_date">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Time Spent (Hours)</label>
                                                <input type="text" class="form-control" id="tank_time_spent"
                                                       name="tank_time_spent">
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Completion Notes</label>
                                                <textarea class="form-control" id="taskcompletion" name="taskcompletion"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-outline-info" onclick="addTask()">
                                                    Add
                                                    Task
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <input type="hidden" id="task_data" name="task_data" value="[]">

                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Work Order Task List</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Description</th>
                                                <th>Start Date</th>
                                                <th>Completion Date</th>
                                                <th>Time Spent</th>
                                                <th>Completion Notes</th>
                                                <th>Assign Labor</th>
                                                <th>Completed Assign</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="task_list">
                                            <!-- Dynamic rows will be added here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="misc" role="tabpanel" aria-labelledby="misc-tab">
                        <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Work Order Misc Cost</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="misc_type">Type</label>
                                                <select class="form-select select2" id="misc_type" name="misc_type[]">
                                                    <option value="">Select Type</option>
                                                    @foreach($business as $bus)
                                                        <option value="{{$bus->id}}"
                                                                data-name="{{$bus->business_name}}">{{$bus->business_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="misc_description">Description</label>
                                                <input type="text" class="form-control" id="misc_description"
                                                       name="misc_description[]">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="misc_est_quantity">Est Quantity</label>
                                                <input type="number" class="form-control" id="misc_est_quantity"
                                                       name="misc_est_quantity[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="misc_est_unit_cost">Est Unit Cost</label>
                                                <input type="number" class="form-control" id="misc_est_unit_cost"
                                                       name="misc_est_unit_cost[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="misc_est_total_cost">Est Total Cost</label>
                                                <input readonly type="text" class="form-control" id="misc_est_total_cost"
                                                       name="misc_est_total_cost[]">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="misc_quantity">Quantity</label>
                                                <input type="number" class="form-control" id="misc_quantity"
                                                       name="misc_quantity[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="misc_actual_unit_cost">Actual Unit Cost</label>
                                                <input type="number" class="form-control" id="misc_actual_unit_cost"
                                                       name="misc_actual_unit_cost[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label for="misc_actual_total_cost">Actual Total Cost</label>
                                                <input readonly type="number" class="form-control" id="misc_actual_total_cost"
                                                       name="misc_actual_total_cost[]">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-info" onclick="addMiscCostRow()">
                                    Add
                                </button>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 mt-3 ">
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
                                    <tbody id="misc-table-body">
                                    <!-- Dynamic rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <div class="tab-pane fade" id="parts" role="tabpanel" aria-labelledby="parts-tab">
                <div class="row m-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Work Order Parts</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="parts">Parts</label>
                                <select class="form-select select2" id="parts_data" name="parts_data">
                                    <option value="" disabled selected>Pilih Part</option>
                                    @foreach ($parts as $part)
                                        <option value="{{ $part['id'] }}">{{ $part['nameParts'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="p_q">Planned Quantity</label>
                                <input type="text" class="form-control" id="p_q" name="p_q">
                            </div>
                            <div class="form-group">
                                <label for="a_q">Actual Quantity</label>
                                <input type="text" class="form-control" id="a_q" name="a_q">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-info" onclick="addPart()">Add
                                    Part
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table basic-table mb-0" id="parts_table">
                                    <thead>
                                    <tr>
                                        <th>Part/Supply</th>
                                        <th>Planned Quantity</th>
                                        <th>Actual Quantity Used</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Container untuk menyimpan input hidden -->
                <div id="hidden_inputs"></div>

            </div>
            <div class="tab-pane fade" id="meterReading" role="tabpanel" aria-labelledby="meterReading-tab">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="card-header d-flex justify-content-between">
                                <h6 class="h6 mb-0">Most Recent Meter Reading</h6>
                                <button class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#meterReadingModal">
                                    Add Meter Reading
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class=" vertical-striped-table mb-0 table">
                                    <thead>
                                    <tr>
                                        <th>Last Reading</th>
                                        <th>Unit</th>
                                        <th>Date Submitted</th>
                                        <th>Submitted By</th>
                                        <th>Submitted Date</th>
                                    </tr>
                                    </thead>
                                    <tbody id="meterReadingTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="meterReadingModal" tabindex="-1"
                     aria-labelledby="meterReadingModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="meterReadingModalLabel">Add Meter Reading</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="meterReadingForm">
                                    <div class="mb-3">
                                        <label for="meterReading" class="form-label">Meter Reading</label>
                                        <input type="number" class="form-control" id="meterReadings"
                                               name="meterReading" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="meterReadingUnit" class="form-label">Unit</label>
                                        <select class="form-select" id="meterReadingUnit" name="meterReadingUnit"
                                                required>
                                            <option value="Hours">Hours (h)</option>
                                            <option value="Kilowatt">Kilowatt (kW)</option>
                                            <option value="Liters">Liters (L)</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="submittedBy" name="submittedBy"
                                           value="{{ \Illuminate\Support\Facades\Auth::user()->name  }}">
                                    <input type="hidden" id="submittedDate" name="submittedDate"
                                           value="{{ date('Y-m-d') }}">
                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                        dssss--}}
            </div>

            {{--                    misccount--}}
            {{--                    <div class="tab-pane fade" id="miscCost" role="tabpanel" aria-labelledby="miscCost-tab">--}}
            {{--                        <div class="row m-3">--}}
            {{--                            <div class="card">--}}

            {{--                                <div class="card-body">--}}
            {{--                                    <div class="mb-4">--}}
            {{--                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Misc Cost</button>--}}
            {{--                                    </div>--}}


            {{--                                    <div class="table-responsive">--}}
            {{--                                        <table class="table basic-table mb-0 ">--}}
            {{--                                            <thead>--}}
            {{--                                            <tr>--}}
            {{--                                                <th>Type</th>--}}
            {{--                                                <th>Description</th>--}}
            {{--                                                <th>Est Quantity</th>--}}
            {{--                                                <th>Est Unit Cost</th>--}}
            {{--                                                <th>Est Total Cost</th>--}}
            {{--                                                <th>Quantity</th>--}}
            {{--                                                <th>Actual Unit Cost</th>--}}
            {{--                                                <th>Actual Total Cost</th>--}}
            {{--                                                <th>Action</th>--}}
            {{--                                            </tr>--}}
            {{--                                            </thead>--}}
            {{--                                            <tbody>--}}


            {{--                                            </tbody>--}}
            {{--                                        </table>--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}

            {{--               notif-tab--}}
            {{--                    <div class="tab-pane fade" id="notif" role="tabpanel" aria-labelledby="notif-tab">--}}
            {{--                        <div class="row m-3">--}}
            {{--                            <div class="card">--}}

            {{--                                <div class="card-body">--}}
            {{--                                    <div class="mb-4">--}}
            {{--                                        <button class="btn btn-primary-600 px-4 py-2 rounded-lg mr-2">Misc Cost</button>--}}
            {{--                                    </div>--}}


            {{--                                    <div class="table-responsive">--}}
            {{--                                        <table class="table basic-table mb-0 ">--}}
            {{--                                            <thead>--}}
            {{--                                            <tr>--}}
            {{--                                                <th>Technisian</th>--}}
            {{--                                                <th>Notify On Assignment</th>--}}
            {{--                                                <th>Notify On Status Change</th>--}}
            {{--                                                <th>Notify On Completion</th>--}}
            {{--                                                <th>Notify On Task Completed</th>--}}
            {{--                                                <th>Notify On Online Offline</th>--}}
            {{--                                            </tr>--}}
            {{--                                            </thead>--}}
            {{--                                            <tbody>--}}


            {{--                                            </tbody>--}}
            {{--                                        </table>--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">

                <!-- Modal -->
                <div id="fileModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Item</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="fileForm">
                                    <div id="modalContent"></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Close
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="saveData()">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="typefile" class="font-weight-bold">Type</label>
                                    <div class="input-group">
                                        <select class="form-control" id="typefile" name="typefile">
                                            <option selected disabled>Pilih</option>
                                            <option value="file">File</option>
                                            <option value="note">Note</option>
                                            <option value="link">Link</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-success"
                                                    onclick="showModal()">New
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="table-responsive">
                    <table class="table basic-table mb-0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Modified</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="fileTableBody">
                        </tbody>
                    </table>
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
                        <div class="form-group">
                            <label for="parent">Parent Work Order</label>
                            <select class="form-select select2" id="childparentwo" name="childparentwo">
                                <option value="">Select Parent Work Order</option>
                                @foreach($workOrders as $workOrder)
                                    <option value="{{ $workOrder->id }}"
                                            data-status="{{ $workOrder->work_order_status }}"

                                    >{{ $workOrder->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="parentdescription"
                                      name="parentdescription"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-info" onclick="childaddWorkOrder()">Add
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Hidden input to store the array of work orders -->
                <input type="hidden" id="hidden_work_orders" name="work_orders" value="[]">

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table basic-table mb-0" id="include_wo">
                                <thead>
                                <tr>
                                    <th>Include Work Order</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Dynamic rows will be added here -->
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("meterReadingForm").addEventListener("submit", function (event) {
                event.preventDefault();
                addMeterReading();
            });
        });

        function addMeterReading() {
            const meterReading = document.getElementById("meterReadings").value;
            const meterReadingUnit = document.getElementById("meterReadingUnit").value;
            const submittedBy = document.getElementById("submittedBy").value;
            const submittedDate = new Date().toLocaleString();

            if (meterReading === "") {
                alert("Meter reading is required!");
                return;
            }

            const tableBody = document.getElementById("meterReadingTableBody");
            const index = tableBody.children.length; // Index untuk input hidden

            const newRow = `
            <tr>
                <td>${meterReading} <input type="hidden" name="meterReading[${index}]" value="${meterReading}"></td>
                <td>${meterReadingUnit} <input type="hidden" name="meterReadingUnit[${index}]" value="${meterReadingUnit}"></td>
                <td>${submittedDate} <input type="hidden" name="submittedDate[${index}]" value="${submittedDate}"></td>
                <td>${submittedBy} <input type="hidden" name="submittedBy[${index}]" value="${submittedBy}"></td>
                <td>${submittedDate}</td>
            </tr>
        `;

            // Menambahkan baris di posisi teratas (sebelum baris pertama)
            tableBody.insertAdjacentHTML("afterbegin", newRow);

            document.getElementById("meterReadingForm").reset();
            document.getElementById("submittedDate").value = submittedDate;
            $("#meterReadingModal").modal("hide");
            $('.modal-backdrop').remove();
        }
    </script>
    <script>
        function updateActionCode() {
            const actionSelect = document.getElementById("action");
            const actionCodeInput = document.getElementById("action_code");

            // Mapping Action Code ke Deskripsi
            const actionMapping = {
                "action_1": "Restart sistem",
                "action_2": "Reset konfigurasi",
                "action_3": "Perbaikan perangkat keras",
                "action_4": "Update software",
                "action_5": "Perbaikan jaringan",
                "action_6": "Restore database",
                "action_7": "Optimasi server",
                "action_8": "Validasi ulang data",
                "action_9": "Training pengguna",
                "action_10": "Troubleshooting manual"
            };

            // Update input Action Code berdasarkan pilihan
            actionCodeInput.value = actionMapping[actionSelect.value] || "";
        }
    </script>

    <script>
        let fileIndex = 0;
        let uploadedFiles = {};

        function showModal() {
            var type = document.getElementById("typefile").value;
            var modalContent = document.getElementById("modalContent");

            if (!type) {
                alert("Please select a type first!");
                return;
            }

            let inputHTML = '';
            if (type === "file") {
                inputHTML = `<label for="fileInput">Select File</label>
                         <input type="file" id="fileInput" class="form-control">`;
            } else if (type === "note") {
                inputHTML = `<label for="noteName">Name</label>
                         <input type="text" id="noteName" class="form-control" placeholder="Enter name">
                         <label for="noteContent" class="mt-2">Note</label>
                         <textarea id="noteContent" class="form-control" placeholder="Enter note"></textarea>`;
            } else if (type === "link") {
                inputHTML = `<label for="linkName">Name</label>
                         <input type="text" id="linkName" class="form-control" placeholder="Enter name">
                         <label for="linkUrl" class="mt-2">Link</label>
                         <input type="url" id="linkUrl" class="form-control" placeholder="Enter link">
                         <label for="linkNote" class="mt-2">Note</label>
                         <textarea id="linkNote" class="form-control" placeholder="Enter note"></textarea>`;
            }

            modalContent.innerHTML = inputHTML;
            $("#fileModal").modal("show");
        }

        function saveData() {
            var type = document.getElementById("typefile").value;
            var tableBody = document.getElementById("fileTableBody");
            var newRow = document.createElement("tr");
            let name, size = "-", modified = new Date().toLocaleString();
            let fileURL = "";

            if (type === "file") {
                var fileInput = document.getElementById("fileInput");
                if (fileInput.files.length === 0) {
                    alert("Please select a file.");
                    return;
                }
                var file = fileInput.files[0];
                name = file.name;
                size = (file.size / 1024).toFixed(2) + " KB";
                fileURL = URL.createObjectURL(file);
            } else if (type === "note") {
                name = document.getElementById("noteName").value;
                let noteContent = document.getElementById("noteContent").value;
                if (!name.trim()) {
                    alert("Please enter a name for the note.");
                    return;
                }
                let noteBlob = new Blob([noteContent], {type: "text/plain"});
                fileURL = URL.createObjectURL(noteBlob);
            } else if (type === "link") {
                name = document.getElementById("linkName").value;
                fileURL = document.getElementById("linkUrl").value;
                if (!name.trim()) {
                    alert("Please enter a name for the link.");
                    return;
                }
            }

            newRow.innerHTML = `
        <td><input type="text" name="files[${fileIndex}][name]" value="${name}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][type]" value="${type}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][size]" value="${size}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][modified]" value="${modified}" readonly class="form-control"></td>
        <td>
            <button class="btn btn-info" onclick="downloadFile('${fileURL}', '${type}')">Download</button>
            <button class="btn btn-outline-danger" onclick="deleteRow(this)">Delete</button>
        </td>
        `;

            tableBody.appendChild(newRow);
            fileIndex++;
            $("#fileModal").modal("hide");
        }

        function deleteRow(button) {
            button.closest("tr").remove();
        }

        function downloadFile(fileURL, type) {
            if (type === "link") {
                window.open(fileURL, "_blank");
            } else {
                let a = document.createElement("a");
                a.href = fileURL;
                a.download = "download";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }
        }
    </script>
    <script>
        function addPart() {
            const partSelect = document.getElementById("parts_data");
            const plannedQty = document.getElementById("p_q").value;
            const actualQty = document.getElementById("a_q").value;
            const hiddenContainer = document.getElementById("hidden_inputs");

            console.log(partSelect.value, plannedQty, actualQty);
            if (!partSelect.value || plannedQty.trim() === "" || actualQty.trim() === "") {
                alert("Silakan lengkapi semua field sebelum menambahkan!");
                return;
            }

            const partText = partSelect.options[partSelect.selectedIndex].text;
            const partId = partSelect.value;

            // Tambahkan data ke tabel
            const tableBody = document.querySelector("#parts_table tbody");
            const newRow = document.createElement("tr");
            const rowId = `row_${Date.now()}`; // Unik ID

            newRow.innerHTML = `
            <td>${partText}</td>
            <td>${plannedQty}</td>
            <td>${actualQty}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removePart('${rowId}')">Hapus</button>
            </td>
        `;

            newRow.id = rowId;
            tableBody.appendChild(newRow);

            // Tambahkan input hidden
            hiddenContainer.innerHTML += `
            <input type="hidden" name="hidden_parts[]" value="${partId}" id="${rowId}_part">
            <input type="hidden" name="hidden_planned[]" value="${plannedQty}" id="${rowId}_planned">
            <input type="hidden" name="hidden_actual[]" value="${actualQty}" id="${rowId}_actual">
        `;

            // Reset form setelah tambah
            partSelect.value = "";
            document.getElementById("p_q").value = "";
            document.getElementById("a_q").value = "";
        }

        function removePart(rowId) {
            // Hapus row dari tabel
            document.getElementById(rowId).remove();

            // Hapus input hidden
            document.getElementById(`${rowId}_part`).remove();
            document.getElementById(`${rowId}_planned`).remove();
            document.getElementById(`${rowId}_actual`).remove();
        }
    </script>
    <script>
        // Function to add work order
        function childaddWorkOrder() {
            // Get values from the form
            const parentWorkOrder = document.getElementById('childparentwo').value;
            const description = document.getElementById('parentdescription').value;
            const selectedOption = document.getElementById('childparentwo').options[document.getElementById('childparentwo').selectedIndex];
            const status = selectedOption.getAttribute('data-status');

            // Validate if the fields are not empty
            if (!parentWorkOrder) {
                alert("Please fill in both fields.");
                return;
            }

            // Create a new row in the table
            const table = document.getElementById('include_wo').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);

            // Add data to the new row
            newRow.insertCell(0).textContent = parentWorkOrder;
            newRow.insertCell(1).textContent = description;
            newRow.insertCell(2).textContent = status;  // You can modify the status dynamically if needed

            // Create a new object for the work order
            const workOrder = {
                parent: parentWorkOrder,
                description: description,
                status: status  // You can modify this if necessary
            };

            // Get the current array of work orders from the hidden input
            const hiddenWorkOrders = JSON.parse(document.getElementById('hidden_work_orders').value);

            // Add the new work order to the array
            hiddenWorkOrders.push(workOrder);

            // Update the hidden input with the new array
            document.getElementById('hidden_work_orders').value = JSON.stringify(hiddenWorkOrders);

            // Clear the form fields
            document.getElementById('parent').value = '';
            document.getElementById('description').value = '';
        }

    </script>

    <script>
        function addTask() {
            // Get values from the form
            const taskType = document.getElementById('task_type').value;
            const description = document.getElementById('task_deskription').value;
            const laborAssign = document.getElementById('labor_assign').value;
            const startDate = document.getElementById('task_start_date').value;
            const timeEstimate = document.getElementById('task_time_estimate').value;
            const assignComplete = document.getElementById('task_assign_complete').value;
            const completionDate = document.getElementById('task_completion_date').value;
            const timeSpent = document.getElementById('tank_time_spent').value;
            const completionNotes = document.getElementById('taskcompletion').value;

            // Validate if the fields are not empty
            if (!taskType || !description || !laborAssign || !startDate || !timeEstimate || !assignComplete || !completionDate || !timeSpent) {
                alert("Please fill in all fields.");
                return;
            }

            // Create a new row in the table
            const tableBody = document.getElementById('task_list');
            const newRow = tableBody.insertRow(tableBody.rows.length);

            // Add the task data to the new row
            newRow.insertCell(0).textContent = taskType;
            newRow.insertCell(1).textContent = description;
            newRow.insertCell(2).textContent = startDate;
            newRow.insertCell(3).textContent = completionDate;
            newRow.insertCell(4).textContent = timeSpent;
            newRow.insertCell(5).textContent = completionNotes;

            // Add the "Assign Labor" and "Completed Assign" to the new row
            const laborAssignCell = newRow.insertCell(6);
            const assignCompleteCell = newRow.insertCell(7);

            // Find the names of the users based on their IDs
            const laborAssignName = document.getElementById('labor_assign').options[document.getElementById('labor_assign').selectedIndex].text;
            const assignCompleteName = document.getElementById('task_assign_complete').options[document.getElementById('task_assign_complete').selectedIndex].text;

            laborAssignCell.textContent = laborAssignName; // Display the selected labor assign user's name
            assignCompleteCell.textContent = assignCompleteName; // Display the selected completed assign user's name

            // Create an action column (e.g., Delete button)
            const actionCell = newRow.insertCell(8);
            actionCell.innerHTML = `<button type="button" class="btn btn-outline-danger" onclick="deleteTask(this)">Delete</button>`;

            // Create a task object to store in the hidden input field
            const taskData = {
                taskType: taskType,
                description: description,
                laborAssign: laborAssign,
                laborAssignName: laborAssignName, // Store the name for future reference
                startDate: startDate,
                timeEstimate: timeEstimate,
                assignComplete: assignComplete,
                assignCompleteName: assignCompleteName, // Store the name for future reference
                completionDate: completionDate,
                timeSpent: timeSpent,
                completionNotes: completionNotes
            };

            // Get the current task data array from the hidden input
            const taskArray = JSON.parse(document.getElementById('task_data').value);

            // Add the new task to the array
            taskArray.push(taskData);

            // Update the hidden input with the new array (as a JSON string)
            document.getElementById('task_data').value = JSON.stringify(taskArray);

            // Clear the form fields
            document.getElementById('task_type').value = '';
            document.getElementById('task_deskription').value = '';
            document.getElementById('labor_assign').value = '';
            document.getElementById('task_start_date').value = '';
            document.getElementById('task_time_estimate').value = '';
            document.getElementById('task_assign_complete').value = '';
            document.getElementById('task_completion_date').value = '';
            document.getElementById('tank_time_spent').value = '';
            document.getElementById('taskcompletion').value = '';
        }

        // Function to delete a task row
        function deleteTask(button) {
            // Remove the row from the table
            const row = button.closest('tr');
            row.remove();

            // Update the hidden input to remove the deleted task
            const taskArray = JSON.parse(document.getElementById('task_data').value);
            const index = Array.from(row.parentNode.children).indexOf(row);

            // Remove the task from the array
            taskArray.splice(index, 1);

            // Update the hidden input with the new array
            document.getElementById('task_data').value = JSON.stringify(taskArray);
        }

    </script>


    <script>
        document.getElementById('misc_est_quantity').addEventListener('input', function () {
            var quantity = parseFloat(this.value) || 0; // Convert to number (default to 0 if invalid)
            var unitCost = parseFloat(document.getElementById('misc_est_unit_cost').value) || 0;
            var totalCost = quantity * unitCost;
            document.getElementById('misc_est_total_cost').value = totalCost.toFixed(2); // Optional: set to 2 decimal places
        });

        document.getElementById('misc_est_unit_cost').addEventListener('input', function () {
            var quantity = parseFloat(document.getElementById('misc_est_quantity').value) || 0;
            var unitCost = parseFloat(this.value) || 0; // Convert to number (default to 0 if invalid)
            var totalCost = quantity * unitCost;
            document.getElementById('misc_est_total_cost').value = totalCost.toFixed(2); // Optional: set to 2 decimal places
        });

        document.getElementById('misc_quantity').addEventListener('input', function () {
            var quantity = parseFloat(this.value) || 0; // Convert to number (default to 0 if invalid)
            var unitCost = parseFloat(document.getElementById('misc_actual_unit_cost').value) || 0;
            var totalCost = quantity * unitCost;
            document.getElementById('misc_actual_total_cost').value = totalCost.toFixed(2); // Optional: set to 2 decimal places
        });

        document.getElementById('misc_actual_unit_cost').addEventListener('input', function () {
            var quantity = parseFloat(document.getElementById('misc_quantity').value) || 0;
            var unitCost = parseFloat(this.value) || 0; // Convert to number (default to 0 if invalid)
            var totalCost = quantity * unitCost;
            document.getElementById('misc_actual_total_cost').value = totalCost.toFixed(2); // Optional: set to 2 decimal places
        });


        // Add Row to Table
        function addMiscCostRow() {
            // Get values from input fields
            var type = document.getElementById('misc_type').value;
            const selectedOption = document.getElementById('misc_type').options[document.getElementById('misc_type').selectedIndex];
            const name = selectedOption.getAttribute('data-name');

            var description = document.getElementById('misc_description').value;
            var estQuantity = document.getElementById('misc_est_quantity').value;
            var estUnitCost = document.getElementById('misc_est_unit_cost').value;
            var estTotalCost = document.getElementById('misc_est_total_cost').value;
            var quantity = document.getElementById('misc_quantity').value;
            var actualUnitCost = document.getElementById('misc_actual_unit_cost').value;
            var actualTotalCost = document.getElementById('misc_actual_total_cost').value;


            // Create a new row
            var row = document.createElement('tr');

            // Create table cells with input values
            row.innerHTML = `
            <td><input type="text" value="${type}" hidden />${name}</td>
            <td><input type="text" value="${description}" readonly /></td>
            <td><input type="number" value="${estQuantity}" readonly /></td>
            <td><input type="number" value="${estUnitCost}" readonly /></td>
            <td><input type="number" value="${estTotalCost}" readonly /></td>
            <td><input type="number" value="${quantity}" readonly /></td>
            <td><input type="number" value="${actualUnitCost}" readonly /></td>
            <td><input type="number" value="${actualTotalCost}" readonly /></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
        `;

            // Append the new row to the table body
            document.getElementById('misc-table-body').appendChild(row);

            // Clear the form inputs
            document.getElementById('misc_type').value = '';
            document.getElementById('misc_description').value = '';
            document.getElementById('misc_est_quantity').value = '';
            document.getElementById('misc_est_unit_cost').value = '';
            document.getElementById('misc_est_total_cost').value = '';
            document.getElementById('misc_quantity').value = '';
            document.getElementById('misc_actual_unit_cost').value = '';
            document.getElementById('misc_actual_total_cost').value = '';
        }

        // Delete Row from Table
        document.getElementById('misc-table-body').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('delete-row')) {
                // Remove the row
                e.target.closest('tr').remove();
            }
        });
    </script>

@endsection

