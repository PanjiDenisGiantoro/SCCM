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
                <button class="btn btn-primary m-2">Submit</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    {{--                    form wo--}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name Project</label>
                                        <input type="date" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Description</label>
                                        <textarea class="form-control" id="name" rows="3"></textarea>
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
                    <button class="nav-link" id="scheduler-tab" data-bs-toggle="tab" data-bs-target="#scheduler"
                            type="button"
                            role="tab" aria-controls="scheduler" aria-selected="false">Scheduler Maintenance <span
                            class="badge bg-gray-200 text-gray-700">3</span></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="work-tab" data-bs-toggle="tab" data-bs-target="#work"
                            type="button" role="tab" aria-controls="work" aria-selected="false">Work Orders
                        <span class="badge bg-gray-200 text-gray-700">2</span></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="technician-tab" data-bs-toggle="tab" data-bs-target="#technician"
                            type="button" role="tab" aria-controls="technician" aria-selected="false">Technician <span
                            class="badge bg-gray-200 text-gray-700">3</span></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files"
                            type="button" role="tab" aria-controls="files" aria-selected="false">Files <span
                            class="badge bg-gray-200 text-gray-700">3</span></button>
                </li>{{--                        warranties--}}

            </ul>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Project Dates</h6>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="summary">Project Start Date</label>
                                    <input type="date" class="form-control" id="summary">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="customer">Project End Date</label>
                                    <input type="date" class="form-control" id="customer">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <h6 class="fw-semibold">Actual Dates</h6>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="summary">Actual Start Date</label>
                                    <input type="date" class="form-control" id="summary">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="customer">Actual End Date</label>
                                    <input type="date" class="form-control" id="customer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="scheduler" role="tabpanel" aria-labelledby="scheduler-tab">
                    <div class="row m-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0 ">
                                        <tr>
                                            <th scope="col">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label">
                                                        No
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col">When</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Asset</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Estimate Hrs</th>
                                            <th scope="col">Assign User</th>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="technician" role="tabpanel" aria-labelledby="technician-tab">
                    <div class="row m-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0 ">
                                        <tr>
                                            <th scope="col">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label">
                                                        No
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col">Technician</th>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                    <div class="row m-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0 ">
                                        <tr>
                                            <th scope="col">
                                                <div class="form-check style-check d-flex align-items-center">
                                                    <label class="form-check-label">
                                                        No
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Work Order Status</th>
                                            <th scope="col">Asset</th>
                                            <th scope="col">Description</th>
                                        </tr>

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

