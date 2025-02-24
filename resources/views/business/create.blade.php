@extends('layout.layout2')

@php
    $title = 'Business';
    $subTitle = 'Business';
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="name">Name Business</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Code</label>
                                        <input type="text" class="form-control" id="name">
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
                            type="button" role="tab" aria-controls="general" aria-selected="true">Detail
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
                            <div class="form-group">
                                <label for="name">Primary Contact</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Phone 2</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Fax</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Web Site</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Primary Email</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Secondary Email</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">City</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Province</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Portal Code</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="name">Country</label>
                                <input type="text" class="form-control" id="name">
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

