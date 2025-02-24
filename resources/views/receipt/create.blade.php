@extends('layout.layout2')

@php
    $title = 'Task Group : Receipt-1';
    $subTitle = 'Task Group : Receipt-1';
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark m-2">Back</button>
                <button class="btn btn-primary m-2">Save</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center bg-body-secondary">
                            <h6>
                                Task Group : Receipt-1
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body bg-warning text-center">
                            <h6>
                                Draft
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Supplier</label>
                        <select class="form-select">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Date Ordered</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Date Received</label>
                        <input type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Packing Slip</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">No. Surat Jalan</label>
                        <input type="text" class="form-control">
                    </div>

                </div>


            </div>

        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h6>
                Lines
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table basic-table mb-0">
                    <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Qty Received</th>
                        <th>Previously Received</th>
                        <th>Unit Price</th>
                        <th>Received To</th>
                        <th>Related Puchase Request</th>
                    </tr>

                    </thead>
                </table>
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

