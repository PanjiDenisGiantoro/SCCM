@extends('layout.layout')

@php
    $title = 'List Part and Supplier';
    $subTitle = 'List Part and Supplier';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPermitModal">Add New Permit</button>

        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th>Permit ID</th>
                        <th>Permit Type</th>
                        <th>Facility Reference</th>
                        <th>Issued By</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Add Permit Modal -->
    <div class="modal fade" id="addPermitModal" tabindex="-1" role="dialog" aria-labelledby="addPermitModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermitModalLabel">Add New Permit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addPermitForm">
                        <div class="form-group">
                            <label for="permitType">Permit Type</label>
                            <select class="form-control" id="permitType" required>
                                <option value="Construction">Construction</option>
                                <option value="Renovation">Renovation</option>
                                <option value="Safety">Safety</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="facilityReference">Facility/Building Reference</label>
                            <input type="text" class="form-control" id="facilityReference" required>
                        </div>
                        <div class="form-group">
                            <label for="issuedBy">Issued By</label>
                            <input type="text" class="form-control" id="issuedBy" required>
                        </div>
                        <div class="form-group">
                            <label for="expirationDate">Expiration Date</label>
                            <input type="date" class="form-control" id="expirationDate" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="complianceDocuments">Compliance Documents</label>
                            <textarea class="form-control" id="complianceDocuments"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Permit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
@endsection
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
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

