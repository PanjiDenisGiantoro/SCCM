@extends('layout.layout2')

@php
    $title = 'Work Order Administration: WO 144';
    $subTitle = 'Work Order Administration: WO 144';
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark m-2">Back</button>
                <div class="dropdown">
                    <button class="btn btn-outline-info dropdown-toggle m-2" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
                        <li><a class="dropdown-item" href="#">Submit</a></li>
                        <li><a class="dropdown-item" href="#">Create Schedule</a></li>
                        <li><a class="dropdown-item" href="#">Submit Request for Approval</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
{{--                            image mesin pabrik online--}}
                            <img src="https://humanfocus.co.uk/wp-content/uploads/entry-level-construction-jobs.jpg" alt="Image" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Code: WO 144</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <img
{{--                                        image qrcode online--}}
                                        src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://example.com"
                                        alt="Image" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    {{--                    form wo--}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Work Order Status</label>
                                        <select class="form-control" id="name">
                                            <option value="option1">Open</option>
                                            <option value="option2">Closed</option>
                                            <option value="option3">In Progress</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Asset</label>
                                        <select class="form-control" id="name">
                                            <option value="option1">Asset 1</option>
                                            <option value="option2">Asset 2</option>
                                            <option value="option3">Asset 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Priority</label>
                                        <select class="form-control" id="name">
                                            <option value="option1">High</option>
                                            <option value="option2">Medium</option>
                                            <option value="option3">Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Maintenance Type</label>
                                        <select class="form-control" id="name">
                                            <option value="option1">Maintenance 1</option>
                                            <option value="option2">Maintenance 2</option>
                                            <option value="option3">Maintenance 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Project</label>
                                        <select class="form-control" id="name">
                                            <option value="option1">Maintenance 1</option>
                                            <option value="option2">Maintenance 2</option>
                                            <option value="option3">Maintenance 3</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Suggested Start Date</label>
                                        <input type="date" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Suggested Completion Date</label>
                                        <input type="date" class="form-control" id="name">
                                    </div>
                                </div>
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
                                    <label for="summary">Summary</label>
                                    <textarea class="form-control" id="summary" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer">Problem Code</label>
                                    <select class="form-control" id="customer">
                                        <option value="option1">problem 1</option>
                                        <option value="option2">problem 2</option>
                                        <option value="option3">problem 3</option>
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
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="assign">Assign To User</label>
                                <select class="form-control" id="assign">
                                    <option value="option1">User 1</option>
                                    <option value="option2">User 2</option>
                                    <option value="option3">User 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="labor">Estimated Labor (hours)</label>
                                <input type="text" class="form-control" id="labor" value="4">
                            </div>
                            <div class="form-group">
                                <label for="assign">Completed By User</label>
                                <select class="form-control" id="assign">
                                    <option value="option1">User 1</option>
                                    <option value="option2">User 2</option>
                                    <option value="option3">User 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="labor">Actual Labor (hours)</label>
                                <input type="text" class="form-control" id="labor" value="4">
                            </div>
                            <div class="form-group">
                                <label for="labor">Date Completed </label>
                                <input type="date" class="form-control" id="labor" value="2022-01-01">
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

            @endsection
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

            <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function () {
                    $('#onlineSwitch').change(function () {
                        if ($(this).is(':checked')) {
                            $('#onlineLabel').text('Online');
                            // modal offline
                            $('#offline').modal('show');
                            $('#online').modal('hide');


                            // Additional logic for online status can be added here
                        } else {
                            $('#onlineLabel').text('Offline');
                            $('#online').modal('show');
                            $('#offline').modal('hide');
                            // modal offline

                            // Additional logic for offline status can be added here
                        }
                    });
                    @if(!empty($disable))
                    $('input, textarea, select').prop('disabled', true);
                    @endif
                    // $('#submit').on('click', function () {
                    //     Swal.fire({
                    //         title: 'Are you sure?',
                    //         text: "Do you want to submit the form?",
                    //         icon: 'warning',
                    //         showCancelButton: true,
                    //         confirmButtonColor: '#3085d6',
                    //         cancelButtonColor: '#d33',
                    //         confirmButtonText: 'Yes, submit it!'
                    //     }).then((result) => {
                    //         if (result.isConfirmed) {
                    //             $('#clientForm').submit();
                    //         }
                    //     });
                    // });
                });
            </script>

