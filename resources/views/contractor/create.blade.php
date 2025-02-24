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


            <form>

                <!-- 1. Personal Information -->
                <div class="card mb-4">
                    <div class="card-header bg-body-secondary text-dark">📋 Personal Information</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="workerID" class="form-label">Worker ID (Required)</label>
                            <input type="text" class="form-control" id="workerID" placeholder="Enter Worker ID" required>
                        </div>

                        <div class="mb-3">
                            <label for="workerName" class="form-label">Full Name (Required)</label>
                            <input type="text" class="form-control" id="workerName" placeholder="Enter Full Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="contactInfo" class="form-label">Contact Information</label>
                            <input type="text" class="form-control" id="contactInfo" placeholder="Phone or Email">
                        </div>

                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob">
                        </div>

                        <div class="mb-3">
                            <label for="emergencyContact" class="form-label">Emergency Contact</label>
                            <input type="text" class="form-control" id="emergencyContact" placeholder="Emergency Contact Name & Number">
                        </div>

                        <div class="mb-3">
                            <label for="photoUpload" class="form-label">Photo Upload</label>
                            <input type="file" class="form-control" id="photoUpload">
                        </div>
                    </div>
                </div>

                <!-- 2. Company & Role -->
                <div class="card mb-4">
                    <div class="card-header bg-body-secondary text-dark">🏢 Company & Role</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" placeholder="Enter Company Name">
                        </div>

                        <div class="mb-3">
                            <label for="jobRole" class="form-label">Job Role</label>
                            <select class="form-select" id="jobRole">
                                <option value="" selected>Select Job Role</option>
                                <option value="Electrician">Electrician</option>
                                <option value="HVAC Technician">HVAC Technician</option>
                                <option value="Plumber">Plumber</option>
                                <option value="IT Specialist">IT Specialist</option>
                                <option value="Security">Security</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="specialSkills" class="form-label">Special Skills/Certifications</label>
                            <input type="text" class="form-control" id="specialSkills" placeholder="e.g., First Aid, Forklift License">
                        </div>
                    </div>
                </div>

                <!-- 3. Compliance & Documentation -->
                <div class="card mb-4">
                    <div class="card-header bg-body-secondary text-dark">📑 Compliance & Documentation</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="certificationStatus" class="form-label">Certification & Compliance Status</label>
                            <select class="form-select" id="certificationStatus">
                                <option value="Compliant">Compliant</option>
                                <option value="Pending">Pending</option>
                                <option value="Non-Compliant">Non-Compliant</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="backgroundCheck" class="form-label">Background Check Status</label>
                            <select class="form-select" id="backgroundCheck">
                                <option value="Passed">Passed</option>
                                <option value="Pending">Pending</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="insuranceDetails" class="form-label">Insurance Details</label>
                            <input type="text" class="form-control" id="insuranceDetails" placeholder="Policy Number, Provider">
                        </div>

                        <div class="mb-3">
                            <label for="trainingDate" class="form-label">Health & Safety Training Date</label>
                            <input type="date" class="form-control" id="trainingDate">
                        </div>

                        <div class="mb-3">
                            <label for="permitExpiry" class="form-label">Work Permit Expiry Date</label>
                            <input type="date" class="form-control" id="permitExpiry">
                        </div>
                    </div>
                </div>

                <!-- 4. Work Assignment -->
                <div class="card mb-4">
                    <div class="card-header bg-body-secondary text-dark">🛠️ Work Assignment</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="accessLevel" class="form-label">Access Level</label>
                            <select class="form-select" id="accessLevel">
                                <option value="Public">Public</option>
                                <option value="Restricted">Restricted</option>
                                <option value="Confidential">Confidential</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="shiftSchedule" class="form-label">Shift Schedule</label>
                            <input type="text" class="form-control" id="shiftSchedule" placeholder="e.g., 08:00 - 16:00">
                        </div>

                        <div class="mb-3">
                            <label for="assignedWorkOrders" class="form-label">Assigned Work Orders</label>
                            <textarea class="form-control" id="assignedWorkOrders" rows="3" placeholder="List assigned tasks or work orders"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="supervisorName" class="form-label">Supervisor Name</label>
                            <input type="text" class="form-control" id="supervisorName" placeholder="Enter Supervisor Name">
                        </div>
                    </div>
                </div>

                <!-- 5. Additional Notes -->
                <div class="card mb-4">
                    <div class="card-header bg-body-secondary text-dark">📝 Additional Notes</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks/Comments</label>
                            <textarea class="form-control" id="remarks" rows="3" placeholder="Any additional notes..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- 6. Action Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="button" class="btn btn-danger">Cancel</button>
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

