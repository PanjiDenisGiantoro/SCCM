@extends('layout.layout2')

@php
    $title = 'Business';
    $subTitle = 'Business';
@endphp

@section('content')
    @if(!empty($business))
        <form action="{{ route('business.update', $business->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @else
                <form action="{{ route('business.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                    <h4 class="card-title">
                                        @if(!empty($business))
                                          {{ $business->code }}  {!! DNS1D::getBarcodeHTML('$ '. $business->code, 'C39') !!}
                                       @endif
                                    </h4>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('business.list') }}" class="btn btn-dark m-2">Back</a>
                                <button type="submit" class="btn btn-outline-success m-2">Submit</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Name Business</label>
                                                        <input type="text"
                                                               class="form-control @error('business_name') is-invalid @enderror"
                                                               id="business_name"
                                                               name="business_name"
                                                               value="@if(!empty($business)){{ $business->business_name }}@endif">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name">Status</label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1"
                                                                    @if(!empty($business) && $business->status == 1) selected @endif>
                                                                Active
                                                            </option>
                                                            <option value="0"
                                                                    @if(!empty($business) && $business->status == 0) selected @endif>
                                                                Inactive
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @if(empty($business))

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="typeBusiness">Type Business</label>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="supplier" id="supplier"
                                                                       name="business_classification[]"
                                                                >
                                                                <label class="form-check-label"
                                                                       for="supplier">Supplier</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="manufacturer" id="manufacturer"
                                                                       name="business_classification[]">
                                                                <label class="form-check-label" for="manufacturer">Manufacturer</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="service_provider" id="service_provider"
                                                                       name="business_classification[]">
                                                                <label class="form-check-label" for="service_provider">Service
                                                                    Provider</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="owner" id="owner"
                                                                       name="business_classification[]">
                                                                <label class="form-check-label"
                                                                       for="owner">Owner</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="customer" id="customer"
                                                                       name="business_classification[]">
                                                                <label class="form-check-label"
                                                                       for="customer">Customer</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="typeBusiness">Type Business</label>

                                                            @php
                                                                $types = ['supplier', 'manufacturer', 'service_provider', 'owner', 'customer'];
                                                            @endphp

                                                            @foreach($types as $type)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           value="{{ $type }}" id="{{ $type }}"
                                                                           name="business_classification[]"
                                                                        {{ in_array($type, $selectedTypes) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="{{ $type }}">
                                                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                                                    </label>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>

                                                @endif


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
                                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                                data-bs-target="#general"
                                                type="button" role="tab" aria-controls="general" aria-selected="true">
                                            Detail
                                        </button>
                                    </li>

                                </ul>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="general" role="tabpanel"
                                         aria-labelledby="general-tab">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Phone</label>
                                                    <input type="text"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone" name="phone"
                                                           value="@if(!empty($business)){{ $business->phone }}@endif">
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Web Site</label>
                                                    <input type="text" class="form-control" id="website" name="website"
                                                           value="@if(!empty($business)){{ $business->website }}@endif">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Email Business</label>
                                                    <input type="text" class="form-control" id="email" name="email"
                                                           value="@if(!empty($business)){{ $business->email }}@endif">
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Address</label>
                                                    <textarea class="form-control" id="address" rows="4"
                                                              name="address">@if(!empty($business)){{ $business->address }}@endif</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">City</label>
                                                    <input type="text" class="form-control" id="city" name="city"
                                                           value="@if(!empty($business)){{ $business->city }}@endif">
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Country</label>
                                                    <input type="text" class="form-control" id="country" name="country"
                                                           value="@if(!empty($business)){{ $business->country }}@endif">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
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

