@extends('layout.layout2')

@php
    $title = 'Scheduled Maintenance Details: SM55';
    $subTitle = 'Scheduled Maintenance Details: SM55';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
                                    <input type="text" class="form-control" id="spaceID" placeholder="Enter Space ID"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label for="buildingRef" class="form-label">Building/Floor Reference <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="buildingRef"
                                           placeholder="Enter Building/Floor Reference" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="roomName" class="form-label">Room Name/Number</label>
                                    <input type="text" class="form-control" id="roomName"
                                           placeholder="Enter Room Name or Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="purpose" class="form-label">Purpose</label>
                                    <select class="form-select" id="purpose" required>
                                        <option value="">Select Purpose</option>
                                        <option value="Office">Office</option>
                                        <option value="Warehouse">Warehouse</option>
                                        <option value="Storage">Storage</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="areaSize" class="form-label">Area Size (m²)</label>
                                    <input type="number" class="form-control" id="areaSize"
                                           placeholder="Enter Area Size">
                                </div>
                                <div class="col-md-6">
                                    <label for="capacity" class="form-label">Capacity (People)</label>
                                    <input type="number" class="form-control" id="capacity"
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
                                    <input type="number" class="form-control" id="occupancyRate"
                                           placeholder="Enter Occupancy Rate" min="0" max="100">
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status">
                                        <option value="">Select Status</option>
                                        <option value="Available">Available</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Under Maintenance">Under Maintenance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="tenantName" class="form-label">Tenant/Department Name</label>
                                    <input type="text" class="form-control" id="tenantName"
                                           placeholder="Enter Tenant or Department Name">
                                </div>
                                <div class="col-md-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                                <div class="col-md-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate">
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
                                           placeholder="Enter Agreement Number">
                                </div>
                                <div class="col-md-6">
                                    <label for="rentalCost" class="form-label">Rental Cost (per Month/Year)</label>
                                    <input type="number" class="form-control" id="rentalCost"
                                           placeholder="Enter Rental Cost">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="paymentTerms" class="form-label">Payment Terms</label>
                                    <select class="form-select" id="paymentTerms">
                                        <option value="">Select Payment Terms</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Annually">Annually</option>
                                        <option value="Custom">Custom</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="contactPerson" class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" id="contactPerson"
                                           placeholder="Enter Contact Person">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNumber"
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
                                <select class="selectpicker form-control" id="facilities" multiple >
                                    <option value="AC">AC</option>
                                    <option value="WiFi">WiFi</option>
                                    <option value="Projector">Projector</option>
                                    <option value="CCTV">CCTV</option>
                                    <option value="Parking">Parking</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes/Remarks</label>
                                <textarea class="form-control" id="notes" rows="3"
                                          placeholder="Any additional information..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ✅ 5. Actions -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">Save</button>
                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                        <button type="button" class="btn btn-danger" onclick="window.history.back();">Cancel</button>
                    </div>

                </form>
            </div>
        </div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

<script>
    $('.selectpicker').selectpicker({

    });

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

