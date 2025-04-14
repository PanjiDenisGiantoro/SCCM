@extends('layout.layout2')

@php
if(!empty($oppanancy)){
    $title = 'Edit Occupancy Space';
    $subTitle = 'Edit Occupancy Space';

}else{
    $title = 'Add Occupancy Space ';
    $subTitle = 'Add Occupancy Space';
    }
@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <style>
        span {
            display: inline;
        }
    </style>
        <div class="card">
            <div class="card-body">


                <form id="spaceForm">
                    <!-- 📋 1. Space Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-body-secondary ">
                            📋 1. Space Information
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="spaceID" class="form-label">Space ID <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="spaceID"name="space_id"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->space_id }}@endif"
                                           placeholder="Enter Space ID"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="buildingRef" class="form-label">Building/Floor Reference <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" id="buildingRef" required name="building_ref">
                                        <option>Select Building/Floor Reference</option>
                                        @foreach($facility as $fac)
                                            @if(!empty($oppanancy) && $oppanancy->building_ref == $fac->id)
                                                <option value="{{ $fac->id }}" selected>{{ $fac->name }}</option>
                                            @else
                                            <option value="{{ $fac->id }}">{{ $fac->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="roomName" class="form-label">Room Name/Number</label>
                                    <input type="text" class="form-control" id="roomName" name="room_name"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->room_name }}@endif"
                                           placeholder="Enter Room Name or Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="purpose" class="form-label">Purpose</label>
                                    <select class="form-select" id="purpose" required name="purpose">
                                        <option value="">Select Purpose</option>
                                        <option value="Office"
                                        @if(!empty($oppanancy) && $oppanancy->purpose == 'Office') selected @endif
                                        >Office</option>
                                        <option value="Warehouse"
                                        @if(!empty($oppanancy) && $oppanancy->purpose == 'Warehouse') selected @endif
                                        >Warehouse</option>
                                        <option value="Storage"
                                        @if(!empty($oppanancy) && $oppanancy->purpose == 'Storage') selected @endif
                                        >Storage</option>
                                        <option value="Other"
                                        @if(!empty($oppanancy) && $oppanancy->purpose == 'Other') selected @endif
                                        >Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="areaSize" class="form-label">Area Size (m²)</label>
                                    <input type="number" class="form-control" id="areaSize"  name="area_size"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->area_size }}@endif"
                                           placeholder="Enter Area Size">
                                </div>
                                <div class="col-md-6">
                                    <label for="capacity" class="form-label">Capacity (People)</label>
                                    <input type="number" class="form-control" id="capacity"  name="capacity"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->capacity }}@endif"
                                           placeholder="Enter Capacity">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 🔄 2. Occupancy Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-body-secondary ">
                            🔄 2. Occupancy Details
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="occupancyRate" class="form-label">Occupancy Rate (%)</label>
                                    <input type="number" class="form-control" id="occupancyRate"  name="occupancy_rate"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->occupancy_rate }}@endif"
                                           placeholder="Enter Occupancy Rate" min="0" max="100">
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Select Status</option>
                                        <option value="Available"
                                        @if(!empty($oppanancy) && $oppanancy->status == 'Available') selected @endif
                                        >Available</option>
                                        <option value="Occupied"
                                        @if(!empty($oppanancy) && $oppanancy->status == 'Occupied') selected @endif
                                        >Occupied</option>
                                        <option value="Under Maintenance"
                                        @if(!empty($oppanancy) && $oppanancy->status == 'Under Maintenance') selected @endif
                                        >Under Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tenantName" class="form-label">Tenant/Department Name</label>
                                    <input type="text" class="form-control" id="tenantName" name="tenant_name"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->tenant_name }}@endif"
                                           placeholder="Enter Tenant or Department Name">
                                </div>
                                <div class="col-md-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->start_date }}@endif"
                                           name="start_date">
                                </div>
                                <div class="col-md-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->end_date }}@endif"
                                           name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 💸 3. Lease/Agreement Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-body-secondary text-dark">
                            💸 3. Lease/Agreement Information
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leaseNumber" class="form-label">Lease/Agreement Number</label>
                                    <input type="text" class="form-control" id="leaseNumber"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->lease_number }}@endif"
                                           name="lease_number"
                                           placeholder="Enter Agreement Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="rentalCost" class="form-label">Rental Cost (per Month/Year)</label>
                                    <input type="number" class="form-control" id="rentalCost"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->rental_cost }}@endif"
                                           name="rental_cost"
                                           placeholder="Enter Rental Cost">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="paymentTerms" class="form-label">Payment Terms</label>
                                    <select class="form-select" id="paymentTerms" name="payment_terms">
                                        <option value="">Select Payment Terms</option>
                                        <option value="Monthly"
                                        @if(!empty($oppanancy) && $oppanancy->payment_terms == 'Monthly') selected @endif
                                        >Monthly</option>
                                        <option value="Annually"
                                        @if(!empty($oppanancy) && $oppanancy->payment_terms == 'Annually') selected @endif
                                        >Annually</option>
                                        <option value="Custom"
                                        @if(!empty($oppanancy) && $oppanancy->payment_terms == 'Custom') selected @endif
                                        >Custom</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="contactPerson" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" id="contactPerson"
                                           value="@if(!empty($oppanancy)){{ $oppanancy->contact_person }}@endif"
                                           name="contact_person"
                                           placeholder="Enter Contact Person">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber"
                                       value="@if(!empty($oppanancy)){{ $oppanancy->contact_number }}@endif"
                                       name="contact_number"
                                       placeholder="Enter Contact Number">
                            </div>
                        </div>
                    </div>

                    <!-- 🛋️ 4. Facilities & Notes -->
                    <div class="card mb-4">
                        <div class="card-header bg-body-secondary">
                            🛋️ 4. Facilities & Notes
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="facilities" class="form-label">Amenities/Facilities</label>
                                <select class="selectpicker form-control select2" id="facilities" name="facilities[]" multiple >
                                    <option value="AC"
                                    @if(!empty($oppanancy) && in_array('AC', explode(',', $oppanancy->facilities))) selected @endif
                                    >AC</option>
                                    <option value="WiFi"
                                    @if(!empty($oppanancy) && in_array('WiFi', explode(',', $oppanancy->facilities))) selected @endif
                                    >WiFi</option>
                                    <option value="Projector"
                                    @if(!empty($oppanancy) && in_array('Projector', explode(',', $oppanancy->facilities))) selected @endif>Projector</option>
                                    <option value="CCTV"
                                    @if(!empty($oppanancy) && in_array('CCTV', explode(',', $oppanancy->facilities))) selected @endif
                                    >CCTV</option>
                                    <option value="Parking"
                                    @if(!empty($oppanancy) && in_array('Parking', explode(',', $oppanancy->facilities))) selected @endif
                                    >Parking</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes/Remarks</label>
                                <textarea class="form-control" id="notes" rows="3"  name="notes"
                                          placeholder="Any additional information...">@if(!empty($oppanancy)){{ $oppanancy->notes }}@endif</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ 5. Actions -->
                    <div class="text-center">
                        <button type="submit" id="submitRequest" class="btn btn-outline-info me-2">Save</button>
                        <button type="button" class="btn btn-danger" onclick="window.history.back();">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>

    $(document).ready(function () {

        $('.select2').select2();
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
                    $("#spaceForm").find("input, select, textarea").each(function () {
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
                        @if(!empty($oppanancy)) url: "{{ route('space.update', $oppanancy->id) }}", @else
                        url: "{{ route('space.store') }}", @endif
                        @if(!empty($oppanancy)) method: "PUT", @else method: "POST", @endif
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


