@extends('layout.layout')

@php
    $title = 'Edit Permit Building';
    $subTitle = 'Edit Permit Building';

@endphp
@php
    use Carbon\Carbon;
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <h6 class="card-title mb-0">{{ $permit->facility_reference }}</h6>
        </div>
        <div class="card-body">
            <form id="addPermitForm" method="POST" action="{{ route('permit.update', $permit->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="permitType">Permit Type</label>
                    <select class="form-select select2" id="permitType" name="permit_type" required>
                        <option value="Construction"
                        @if ($permit->permit_type == 'Construction') selected @endif
                        >Construction</option>
                        <option value="Renovation"
                        @if ($permit->permit_type == 'Renovation') selected @endif
                        >Renovation</option>
                        <option value="Safety"
                        @if ($permit->permit_type == 'Safety') selected @endif
                        >Safety</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="facilityReference">Facility/Building Reference</label>
                    <select class="form-select select2" id="facilityReference" name="facility_reference" required>
                        @foreach ($facilities as $facility)
                            <option value="{{ $facility->id }}"
                            @if ($permit->facility_reference == $facility->id) selected @endif
                            >{{ $facility->name }}</option>
                            @foreach($facility->children as $child)
                                <option value="{{ $child->id }}"
                                @if ($permit->facility_reference == $child->id) selected @endif
                                >{{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="issuedBy">Issued By</label>
                    <input type="text" class="form-control" id="issuedBy" name="issued_by"
                           value="@if ($permit->issued_by) {{ $permit->issued_by }} @endif"
                           required>
                </div>
                <div class="form-group">
                    <label for="expirationDate">Expiration Date</label>
                    <input type="date" class="form-control" id="expirationDate"
                           value="@if ($permit->expiration_date) {{ $permit->expiration_date }} @endif"
                           name="expiration_date" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>

                    <select class="form-select" id="status" name="status" required>
                        <option value="Pending"
                        @if ($permit->status == 'Pending') selected @endif
                        >Pending</option>
                        <option value="Approved"
                        @if ($permit->status == 'Approved') selected @endif
                        >Approved</option>
                        <option value="Expired"
                        @if ($permit->status == 'Expired') selected @endif
                        >Expired</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="complianceDocuments">Compliance Documents</label>
                    <textarea class="form-control" id="complianceDocuments" name="compliance_documents">@if ($permit->compliance_documents) {{ $permit->compliance_documents }} @endif</textarea>
                </div>
                <button type="submit" class="btn btn-outline-info">Edit Permit</button>
            </form>

        </div>
    </div>



    <!-- Modal -->
@endsection
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    // Sample data for demonstration
    let permits = [];

    // Function to render permits in the table
    function renderPermits() {
        const tableBody = document.getElementById('permitTableBody');
        tableBody.innerHTML = ''; // Clear existing rows
        permits.forEach((permit, index) => {
            const row = `
                    <tr>
                        <td>${permit.PermitID}</td>
                        <td>${permit.PermitType}</td>
                        <td>${permit.FacilityReference}</td>
                        <td>${permit.IssuedBy}</td>
                        <td>${permit.ExpirationDate}</td>
                        <td>${permit.Status}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editPermit(${index})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deletePermit(${index})">Delete</button>
                        </td>
                    </tr>
                `;
            tableBody.innerHTML += row;
        });
    }

    // Function to handle form submission
    document.getElementById('addPermitForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        const newPermit = {
            PermitID: permits.length + 1, // Simple ID generation
            PermitType: document.getElementById('permitType').value,
            FacilityReference: document.getElementById('facilityReference').value,
            IssuedBy: document.getElementById('issuedBy').value,
            ExpirationDate: document.getElementById('expirationDate').value,
            Status: document.getElementById('status').value,
            ComplianceDocuments: document.getElementById('complianceDocuments').value
        };
        permits.push(newPermit); // Add new permit to the array
        renderPermits(); // Re-render the permits table
        $('#addPermitModal').modal('hide'); // Hide the modal
        this.reset(); // Reset the form
    });

    // Function to delete a permit
    function deletePermit(index) {
        permits.splice(index, 1); // Remove permit from the array
        renderPermits(); // Re-render the permits table
    }

    // Function to edit a permit (not fully implemented)
    function editPermit(index) {
        // Logic for editing a permit can be implemented here
        alert('Edit functionality is not implemented yet.');
    }

    // Initial render
    renderPermits();
</script>

