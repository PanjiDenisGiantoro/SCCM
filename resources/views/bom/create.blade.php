@extends('layout.layout2')

@php
    $title = 'BOM Group ';
    $subTitle = 'BOM Group';
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
                                        <label for="name">Name BOM Group</label>
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
                    <button class="nav-link active" id="part-tab" data-bs-toggle="tab" data-bs-target="#part"
                            type="button" role="tab" aria-controls="part" aria-selected="true">Parts List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bom-tab" data-bs-toggle="tab" data-bs-target="#bom"
                            type="button"
                            role="tab" aria-controls="bom" aria-selected="false">Assets BOM <span
                            class="badge bg-gray-200 text-gray-700">3</span></button>
                </li>

            </ul>

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="part" role="tabpanel" aria-labelledby="part-tab">
                    <div class="row">
                      <div class="table-responsive">
                          <table class="table basic-table mb-2">
                              <tr>
                                  <th>Part</th>
                                  <th>Qty</th>
                              </tr>
                          </table>
                      </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="bom" role="tabpanel" aria-labelledby="bom-tab">
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
                                            <th scope="col">Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Asset Location</th>
                                        </tr>

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

