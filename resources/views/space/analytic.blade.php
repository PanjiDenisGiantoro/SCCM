@extends('layout.layout2')

@php
    $title = 'Analytics Space Occupancy';
    $subTitle = 'Analytics Space Occupancy';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="card">
        <div class="card-body">

            <form>

                <!-- 📅 Date Range Selection -->
                <div class="form-section">
                    <h5>📅 Date Range</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                    </div>
                </div>

                <!-- 🏢 Space Selection -->
                <div class="form-section">
                    <h5>🏢 Space Selection</h5>
                    <div class="mb-3">
                        <label for="building" class="form-label">Building</label>
                        <select class="form-select" id="building">
                            <option selected disabled>Select Building</option>
                            <option value="Building A">Building A</option>
                            <option value="Building B">Building B</option>
                            <option value="Building C">Building C</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="floor" class="form-label">Floor</label>
                        <select class="form-select" id="floor">
                            <option selected disabled>Select Floor</option>
                            <option value="1">1st Floor</option>
                            <option value="2">2nd Floor</option>
                            <option value="3">3rd Floor</option>
                        </select>
                    </div>
                </div>

                <!-- 📈 Analytics Options -->
                <div class="form-section">
                    <h5>📈 Analytics Options</h5>
                    <div class="mb-3">
                        <label for="analysisType" class="form-label">Analysis Type</label>
                        <select class="form-select" id="analysisType">
                            <option selected disabled>Select Analysis Type</option>
                            <option value="occupancy">Occupancy Rate</option>
                            <option value="utilization">Space Utilization</option>
                            <option value="cost">Cost Efficiency</option>
                            <option value="trend">Trend Analysis</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Include:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeVacant">
                            <label class="form-check-label" for="includeVacant">Vacant Spaces</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeOccupied">
                            <label class="form-check-label" for="includeOccupied">Occupied Spaces</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeMaintenance">
                            <label class="form-check-label" for="includeMaintenance">Under Maintenance</label>
                        </div>
                    </div>
                </div>

                <!-- 💬 Notes -->
                <div class="form-section">
                    <label for="notes" class="form-label">Notes/Remarks</label>
                    <textarea class="form-control" id="notes" rows="3" placeholder="Add any additional notes..."></textarea>
                </div>

                <!-- ✅ Action Buttons -->
                <div class="form-section text-center">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
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

