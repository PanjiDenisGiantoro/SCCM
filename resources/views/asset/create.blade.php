@extends('layout.layout2')

@php
    $title = 'Facility';
    $subTitle = 'Facility';
@endphp

@section('content')

    <style>
        .upload-container {
            position: relative;
            width: 120px;
            height: 120px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            overflow: hidden;
        }

        .upload-box {
            text-align: center;
        }

        .upload-icon {
            font-size: 30px;
            color: #555;
        }

        .upload-text {
            font-size: 12px;
            color: #777;
        }

        .preview-hidden {
            display: none;
            border-radius: 5px;
            object-fit: cover;
        }
    </style>

    <form id="facility-form">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Facility Form</h6>
                        <button type="button" class="btn btn-outline-success btnsubmitall" id="submitFormBtn">Submit Form</button>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h1 class="h5 font-weight-bold">

                            </h1>
                            <div class="d-flex align-items-center">
                                <div class="form-check form-switch switch-success d-flex align-items-center gap-3">
                                    <input class="form-check-input" type="checkbox" id="onlineSwitch" name="online" value="1" role="switch" checked>
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="onlineSwitch" id="onlineLabel">Online</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-4">
                            <div class="upload-container">
                                <input type="file" id="uploadImage" accept="image/*" hidden>
                                <label for="uploadImage" class="upload-label">
                                    <div class="upload-box">
                                        <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                        <p class="upload-text">Upload Image</p>
                                    </div>
                                </label>
                                <img id="previewImage" class="img-fluid mt-2 preview-hidden" width="100" height="100" />
                            </div>

                            <div class="flex-grow-1 ms-3">
                                <div class="mb-2">
                                    <label class="form-label">New Facility</label>
                                    <input class="form-control" type="text" name="nameFacility" required />
                                </div>
                                <div class="d-flex">
                                    <div class="flex-grow-1 me-2">
                                        <label class="form-label">Category</label>
                                        <div class="input-group">
                                            <select class="form-select" id="categoryDropdown" name="categoryfacility">
                                                <option value="">-- Select Category --</option>
                                            </select>
                                            <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                    data-bs-target="#categoryModal">Manage
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" onclick="uploadFacilityImage()">Upload Image</button>
                    </div>
                    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel"
                         aria-hidden="false">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="categoryModalLabel">Manage Categories</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Add Category Form -->
                                    <div class="d-flex mb-3">
                                        <input type="text" id="newCategory" class="form-control"
                                               placeholder="New Category">
                                        <select class="form-select me-2" id="parentCategory">
                                            <option value="">-- Select Parent --</option>
                                        </select>
                                        <button class="btn btn-outline-success ms-2" id="addCategoryBtn">Add</button>
                                    </div>

                                    <!-- Category Table -->
                                    <table class="table table-bordered" id="categoryTable">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name</th>
                                            <th style="display: none">Parent</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- Dynamic Rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4 bg-body-secondary" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                                        data-bs-target="#general" type="button" role="tab" aria-controls="general"
                                        aria-selected="false">General
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts"
                                        type="button" role="tab" aria-controls="parts" aria-selected="false">Parts/BOM
                                   </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="metering-tab" data-bs-toggle="tab"
                                        data-bs-target="#metering" type="button" role="tab" aria-controls="metering"
                                        aria-selected="false">Metering/Events
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="personnel-tab" data-bs-toggle="tab"
                                        data-bs-target="#personnel" type="button" role="tab" aria-controls="personnel"
                                        aria-selected="false">Personnel
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files"
                                        type="button" role="tab" aria-controls="files" aria-selected="false">Files</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="financials-tab" data-bs-toggle="tab"
                                        data-bs-target="#financials" type="button" role="tab" aria-controls="financials"
                                        aria-selected="false">Financials
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log"
                                        type="button" role="tab" aria-controls="log" aria-selected="false">Log</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                 aria-labelledby="general-tab">
                                <div class="mb-4">
                                    <h2 class="h6 font-weight-bold mb-2">Location</h2>
                                    <div class="mb-2">
                                        <input  class="form-check-input" id="partOf" name="location" type="radio" value="0" />
                                        <label class="form-check-label" for="partOf">This facility is a part of:</label>

                                        <select class="form-select d-inline-block" id="locationSelect" name="locationid" style="width: auto;">
                                            <option value="">-- Select Location --</option>
                                        </select>
                                    </div>

                                    <div class="ms-3 mb-2">
                                        <p class="text-muted" id="locationname">Jl. Indonesia Raya, Bekasi, Jawa barat, 17426, Indonesia,
                                            Republic of</p>
                                    </div>
                                    <div class="mb-2">
                                        <input class="form-check-input" id="notPartOf" name="location" type="radio" value="1" checked/>
                                        <label class="form-check-label" for="notPartOf">This facility is not part of
                                            another location, and is located at:</label>
                                    </div>
                                    <div class="ms-3" id="biodata">
                                        <div class="mb-2">
                                            <label class="form-label">Address</label>
                                            <input class="form-control" type="text" name="asset_address"/>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1 me-2">
                                                <label class="form-label">City</label>
                                                <input class="form-control" type="text" name="asset_city"/>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Province</label>
                                                <input class="form-control" type="text" name="asset_province"/>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1 me-2">
                                                <label class="form-label">Postal Code</label>
                                                <input class="form-control" type="text" name="asset_postal"/>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Country</label>
                                                <input class="form-control" type="text" name="asset_country"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="h6 font-weight-bold mb-2">General Information</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex mb-4">
                                                <div class="flex-grow-1 me-2">
                                                    <label class="form-label">Account</label>
                                                    <div class="input-group">
                                                        <select class="form-select" id="accountInput" name="account">
                                                            <option value="">-- Select Account --</option>
                                                        </select>
                                                        <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                                data-bs-target="#accountModal">Manage
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal fade" id="accountModal" tabindex="-1"
                                             aria-labelledby="accountModalLabel" aria-hidden="false"  >
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Pilih Account</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form Tambah Account -->
                                                        <div class="mb-3 d-flex">
                                                            <input id="newAccount" class="form-control me-2" type="text"
                                                                   placeholder="Account"/>
                                                            <input id="newDescription" class="form-control me-2"
                                                                   type="text" placeholder="Description"/>
                                                            <button class="btn btn-success" onclick="addAccount()">
                                                                Tambah
                                                            </button>
                                                        </div>

                                                        <!-- Tabel Account -->
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Account</th>
                                                                <th>Description</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="accountTable">
                                                            <!-- Data akan ditambahkan secara dinamis -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="flex-grow-1 me-2">
                                                <label class="form-label">Charge Department</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="chargemanagement"
                                                            name="chargemanagement">
                                                        <option value="">-- Select Charge Department --</option>
                                                    </select>
                                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                            data-bs-target="#ChargeModal">
                                                        Manage
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Charge Department -->
                                        <!-- Modal Manage Charge Department -->
                                        <div class="modal fade" id="ChargeModal" tabindex="-1"
                                             aria-labelledby="ChargeModalLabel" aria-hidden="false">
                                            <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="ChargeModalLabel">Manage Charge
                                                            Department</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="chargeForm">
                                                            <div class="mb-3">
                                                                <label for="chargeCode" class="form-label">Charge
                                                                    Code</label>
                                                                <input type="text" class="form-control" id="chargeCode"
                                                                       required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="chargeDescription" class="form-label">Description</label>
                                                                <input type="text" class="form-control" name="descriptionnote"
                                                                       id="chargeDescription" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="chargeFacility"
                                                                       class="form-label">Facility</label>
                                                                <select class="form-select" id="chargeFacility"
                                                                        required>
                                                                    <option value="">-- Select Facility --</option>
                                                                    <option value="Facility A">Facility A</option>
                                                                    <option value="Facility B">Facility B</option>
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="button" class="btn btn-outline-success"
                                                                onclick="addChargeDepartment()">Save
                                                        </button>
                                                    </div>
                                                    <div class="mt-4">
                                                        <h6>List Charge Department</h6>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Charge Code</th>
                                                                <th>Description</th>
                                                                <th>Facility</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="chargeTableBody">
                                                            <!-- Data akan dimuat oleh JavaScript -->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Table List Charge Department -->

                                    </div>

                                    <div class="d-flex mb-4">

                                        <div class="flex-grow-1">
                                            <label class="form-label">Note</label>
                                            <textarea class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="parts" role="tabpanel" aria-labelledby="parts-tab">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <button class="btn btn-outline-success me-2" data-bs-toggle="modal"
                                                data-bs-target="#addPartModal">Add Part
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class=" vertical-striped-table mb-0 table" id="partsTable">
                                            <thead>
                                            <tr>
                                                <th>Part</th>
                                                <th>Quantity</th>
                                                <th>BOM Control</th>
                                                <th>Qty On Hand</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <!-- Modal -->
                                <div class="modal fade" id="addBOMModal" tabindex="-1" aria-labelledby="addBOMModalLabel" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addBOMModalLabel">Add BOM Group</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addBOMForm">
                                                    <div class="mb-3">
                                                        <label for="bomSelect" class="form-label">Select BOM</label>
                                                        <select class="form-select" id="bomSelect" name="bom_id">
                                                            <option value="">Select a BOM</option>
                                                            <!-- Options will be populated dynamically -->
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-outline-success" id="saveBOMBtn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Add Part -->
                                <div class="modal fade" id="addPartModal" tabindex="-1"
                                     aria-labelledby="addPartModalLabel" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addPartModalLabel">Add Part</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="addPartForm">
                                                    <div class="mb-3">
                                                        <label for="partInput" class="form-label">Select Part</label>
                                                        <select class="form-select" id="partInput">
                                                            <option value="">Loading...</option> <!-- Default loading state -->
                                                        </select>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="partQty" class="form-label">Quantity</label>
                                                        <input type="number" class="form-control" id="partQty" value="1"
                                                               min="1">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-outline-success" id="addPartBtn">Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="partModal" tabindex="-1" aria-labelledby="partModalLabel"
                                     aria-hidden="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="partModalLabel">Select Part</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table" id="partTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Part Name</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Data akan diisi oleh JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="metering" role="tabpanel" aria-labelledby="metering-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="card-header d-flex justify-content-between">
                                                <h6 class="h6 mb-0">Most Recent Meter Reading</h6>
                                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#meterReadingModal">
                                                    Add Meter Reading
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>Last Reading</th>
                                                        <th>Unit</th>
                                                        <th>Date Submitted</th>
                                                        <th>Submitted By</th>
                                                        <th>Submitted Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="meterReadingTableBody">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="meterReadingModal" tabindex="-1" aria-labelledby="meterReadingModalLabel" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="meterReadingModalLabel">Add Meter Reading</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="meterReadingForm">
                                                    <div class="mb-3">
                                                        <label for="meterReading" class="form-label">Meter Reading</label>
                                                        <input type="number" class="form-control" id="meterReading" name="meterReading" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="meterReadingUnit" class="form-label">Unit</label>
                                                        <select class="form-select" id="meterReadingUnit" name="meterReadingUnit" required>
                                                            <option value="Hours">Hours (h)</option>
                                                            <option value="Kilowatt">Kilowatt (kW)</option>
                                                            <option value="Liters">Liters (L)</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" id="submittedBy" name="submittedBy" value="{{ \Illuminate\Support\Facades\Auth::user()->name  }}">
                                                    <input type="hidden" id="submittedDate" name="submittedDate" value="{{ date('Y-m-d') }}">
                                                    <button type="submit" class="btn btn-outline-success">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <div class="card-header d-flex justify-content-between">--}}
{{--                                                <h6 class="h6 mb-0">Most Recent Asset Events</h6>--}}
{{--                                                <button class="btn btn-secondary">Add Asset Event</button>--}}
{{--                                            </div>--}}
{{--                                            <div class="table-responsive">--}}
{{--                                                <table class=" vertical-striped-table mb-0 table">--}}
{{--                                                    <thead>--}}
{{--                                                    <tr>--}}
{{--                                                        <th>Event</th>--}}
{{--                                                        <th>Date Submitted</th>--}}
{{--                                                    </tr>--}}
{{--                                                    </thead>--}}
{{--                                                    <tbody>--}}
{{--                                                    <tr>--}}
{{--                                                        <td>FEI - Forklift</td>--}}
{{--                                                        <td>Feb 22, 2023 8:00 AM</td>--}}
{{--                                                    </tr>--}}
{{--                                                    </tbody>--}}
{{--                                                </table>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>

                            <div class="tab-pane fade" id="personnel" role="tabpanel" aria-labelledby="personnel-tab">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <button id="addPersonnelBtn"
                                                class="btn btn-outline-success">Add
                                            Personnel
                                        </button>
                                        <button id="addGroupBtn" class="btn btn-outline-success">
                                            Add
                                            Personnel Group
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table basic- vertical-striped-table mb-0 table" id="personnelTable">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Modal for Adding Personnel -->
                                <div class="modal fade" id="addPersonnelModal" tabindex="-1"
                                     aria-labelledby="addPersonnelModalLabel" aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addPersonnelModalLabel">Add Personnel</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <select class="form-select" id="selectUser" name="selectUser">
                                                    <option selected>Open this select menu</option>
                                                    @foreach($personelUser as $s)
                                                        <option value="{{$s->id}}" data-name="{{ $s->name }}"
                                                                data-type="User">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" id="savePersonnelBtn" class="btn btn-outline-success">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Adding Group -->
                                <div class="modal fade" id="addGroupModal" tabindex="-1"
                                     aria-labelledby="addGroupModalLabel"
                                     aria-hidden="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addGroupModalLabel">Add Personnel Group</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <select class="form-select" id="selectGroup" name="selectGroup">
                                                    <option selected>Open this select menu</option>
                                                    @foreach($personelGroup as $g)
                                                        <option value="{{$g->id}}" data-name="{{ $g->name }}"
                                                                data-type="Group">{{ $g->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" id="saveGroupBtn" class="btn btn-outline-success">Save Group
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">

                                <!-- Modal -->
                                <div id="fileModal" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add New Item</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="fileForm">
                                                    <div id="modalContent"></div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-outline-success" onclick="saveData()">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body">
                                    <div class="mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="typefile" class="font-weight-bold">Type</label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="typefile" name="typefile">
                                                            <option selected disabled>Pilih</option>
                                                            <option value="file">File</option>
                                                            <option value="note">Note</option>
                                                            <option value="link">Link</option>
                                                        </select>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-success"
                                                                    onclick="showModal()">New
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="table-responsive">
                                    <table class="table basic- vertical-striped-table mb-0 table">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Modified</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="fileTableBody">
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="financials" role="tabpanel" aria-labelledby="financials-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class=" vertical-striped-table mb-0 table">
                                                <thead>
                                                <tr>
                                                    <th>Asset / Sub Asset</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>CPU</td>
                                                    <td>1000</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class=" vertical-striped-table mb-0 table">
                                                <thead>
                                                <tr>
                                                    <th>Total Costs Per Period</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1000</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Schedule Maintenance</h6>
                                            <button class="btn btn-secondary me-2">Add Log</button>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>When</th>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <th>Schedule Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>FEI - Forklift</td>
                                                        <td>Feb 22, 2023 8:00 AM</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Open Work Orders</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>WO-1</td>
                                                        <td>Work Order 1</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Work Orders History</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <th>Date Completed</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>WO-2</td>
                                                        <td>FEI - Forklift</td>
                                                        <td>Feb 22, 2023 8:00 AM</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Part Supply Consumed</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>Work Order</th>
                                                        <th>Stock Item</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>WO-1</td>
                                                        <td>FEI - Forklift</td>
                                                        <td>1000</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Work Order Log</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table">
                                                    <thead>
                                                    <tr>
                                                        <th>Log Date</th>
                                                        <th>Inventory Cost</th>
                                                        <th>Completion Notes</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Feb 22, 2023 8:00 AM</td>
                                                        <td>1000</td>
                                                        <td>
                                                            <button class="btn btn-secondary">View</button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-header">
                                            <h6>Asset Offline Tracker</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class=" vertical-striped-table mb-0 table ">
                                                    <thead>
                                                    <tr>
                                                        <th>Offline From</th>
                                                        <th>Offline By</th>
                                                        <th>Offline To</th>
                                                        <th>Online By</th>
                                                        <th>Production Hours Affected</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>Feb 22, 2023 8:00 AM</td>
                                                        <td>Feb 23, 2023 8:00 AM</td>
                                                        <td>Technician</td>
                                                        <td>Engineer</td>
                                                        <td>8 hours</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- card end -->
            </div>
    </form>
    </body>

    <div class="modal fade" id="offline" tabindex="-1" aria-labelledby="offlineLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offline">SET OFFLINE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label">Offline From</label>
                        <input type="text" class="form-control" value="Feb 18, 2025 05:04:00 PM">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Set Offline By User</label>
                        <select class="form-select">
                            <option>Kevin Adisaputra</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Associated Work Order</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Additional Info</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <h3 class="h6 mb-2">Generate Asset Event</h3>
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="generateEvent">
                            <label class="form-check-label" for="generateEvent">Generate an event</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Event Type</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Event Description</label>
                        <textarea class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="online" tabindex="-1" aria-labelledby="onlineLabel" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onlineLabel">Set Online</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label">Online From</label>
                        <input type="text" class="form-control" value="Feb 18, 2025 05:04:00 PM">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Set Online By User</label>
                        <select class="form-select">
                            <option>Kevin Adisaputra</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Associated Work Order</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Additional Info</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <h3 class="h6 mb-2">Generate Asset Event</h3>
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="generateEventOnline">
                            <label class="form-check-label" for="generateEventOnline">Generate an event</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Event Type</label>
                        <select class="form-select">
                            <option></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Event Description</label>
                        <textarea class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div id="loadingIndicator" style="display: none; text-align: center;">
        <p>Loading data...</p>
    </div>
    <div id="errorMessage" style="display: none; color: red; text-align: center;">
        <p>Failed to load data. Please try again.</p>
    </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        loadAccounts(); // Load data saat halaman dimuat
    });

    // Fungsi menampilkan data ke tabel dengan AJAX
    function loadAccounts() {
        fetch("{{ route('account.list') }}") // Ganti dengan URL API Anda
            .then(response => response.json())
            .then(data => {
                const table = document.getElementById("accountTable");
                table.innerHTML = ""; // Hapus isi tabel sebelum mengisi ulang

                data.forEach((item, index) => {
                    const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.description}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" onclick="selectAccount(${item.id}, '${item.name}', '${item.description}')">Pilih</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteAccount(${item.id})">Hapus</button>
                    </td>
                </tr>`;
                    table.innerHTML += row;
                });
            })
            .catch(error => console.error("Error fetching accounts:", error));
    }

    // Fungsi memilih account
    function selectAccount(id, name, description) {
        const dropdown = document.getElementById("accountInput");

        // Cek apakah account sudah ada di dropdown berdasarkan ID
        let optionExists = false;
        for (let i = 0; i < dropdown.options.length; i++) {
            if (dropdown.options[i].value == id) {
                optionExists = true;
                dropdown.selectedIndex = i; // Pilih opsi yang sudah ada
                break;
            }
        }

        // Jika belum ada, tambahkan ke dropdown
        if (!optionExists) {
            let option = new Option(`${name} - ${description}`, id);
            dropdown.add(option);
            dropdown.value = id;
        }

        $('.modal-backdrop').remove();
        $("#accountModal").modal("hide");
        $('body').removeAttr('style');

    }

    // Fungsi menambah account baru
    function addAccount() {
        const newAccount = document.getElementById("newAccount").value.trim();
        const newDescription = document.getElementById("newDescription").value.trim();

        if (newAccount === "" || newDescription === "") {
            alert("Account dan Description harus diisi!");
            return;
        }

        fetch("{{ route('account.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({name: newAccount, description: newDescription})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadAccounts(); // Refresh tabel
                    document.getElementById("newAccount").value = "";
                    document.getElementById("newDescription").value = "";
                } else {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menambahkan data!',
                    });
                }
            })
            .catch(error => console.error("Error adding account:", error));
    }

    // Fungsi menghapus account berdasarkan ID
    function deleteAccount(id) {
        fetch(`{{ url('account/destroy_account') }}/${id}`, {method: "GET"})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadAccounts(); // Refresh tabel
                } else {
                    alert("Gagal menghapus data!");
                }
            })
            .catch(error => console.error("Error deleting account:", error));
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const locationRadios = document.querySelectorAll('input[name="location"]');
        const biodataSection = document.getElementById("biodata");
        const locationInfo = document.getElementById("locationname");
        const locationSelect = document.getElementById("locationSelect");

        function toggleBiodata() {
            const selected = document.querySelector('input[name="location"]:checked');

            if (selected) {
                if (selected.value === "1") {
                    // Reset location info dan dropdown jika nilai adalah 1
                    locationInfo.innerHTML = "<em>Please select a location.</em>";
                    locationSelect.value = ""; // Reset dropdown
                    locationSelect.disabled = true; // Optional: Disable dropdown
                } else {
                    locationSelect.disabled = false; // Enable dropdown
                }

                biodataSection.style.display = (selected.id === "partOf") ? "none" : "block";
            }
        }

        // Jalankan fungsi untuk set kondisi awal
        toggleBiodata();

        locationRadios.forEach(radio => {
            radio.addEventListener("change", toggleBiodata);
        });
    });

</script>
<script>
    $(document).ready(function () {


        $('#onlineSwitch').change(function () {
            if ($(this).is(':checked')) {
                $('#onlineLabel').text('Online');
                $('#offline').modal('show');
                $('#online').modal('hide');
            //     value
                $('#onlineSwitch').val(1);
            } else {
                $('#onlineLabel').text('Offline');
                $('#online').modal('show');
                $('#offline').modal('hide');
                $('#onlineSwitch').val(0);

            }
        });


        $("#submitformbutton").click(function () {
            let formData = {};

            // Ambil semua input dalam div #submitform
            $("#submitform input, #submitform select, #submitform textarea").each(function () {
                if (this.type === "checkbox") {
                    formData[this.name] = this.checked;
                } else {
                    formData[this.name] = this.value;
                }
            });

            console.log(formData); // Debugging data sebelum dikirim

            // Kirim data dengan AJAX
            $.ajax({
                url: "{{ route('part.store') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function (response) {
                    swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Part saved successfully!',
                    })
                    window.location.href = "{{ route('part.list') }}";
                },
                error: function () {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save part. Please try again.',
                    })
                    window.location.href = "{{ route('part.list') }}";
                }
            });
        });
        // 🚀 Load Categories on Page Load
        loadCategories();

        function loadCategories() {
            $.ajax({
                url: '{{ route("categories.getFacility") }}',
                method: 'GET',
                success: function (data) {
                    $('#categoryTable tbody').empty();
                    $('#categoryDropdown, #parentCategory').empty().append('<option value="">-- Select Category --</option>');

                    // 🎯 Render nested data
                    $.each(data, function (index, category) {
                        appendCategoryRow(category, 0); // Start at level 0
                    });
                }
            });
        }

        // 🌳 Recursive Function to Render Category Rows
        function appendCategoryRow(category, level) {
            let indent = '&nbsp;'.repeat(level * 4); // Indent based on level

            // 👉 Append category to table with "Pilih" button
            $('#categoryTable tbody').append(`
            <tr>
                <td>${category.id}</td>
                <td>${indent}${level > 0 ? '↳ ' : ''}${category.category_name}</td>
                <td style="display: none">${category.parent_id ? category.parent_id : 'None'}</td>
                <td>
                    <button class="btn btn-sm btn-success selectCategoryBtn" data-id="${category.id}" data-name="${category.category_name}">Pilih</button>
                    <button class="btn btn-sm btn-danger deleteCategoryBtn" data-id="${category.id}">Delete</button>
                </td>
            </tr>
        `);

            // 👉 Append to parent category dropdown
            $('#parentCategory').append(`<option value="${category.id}">${indent}${category.category_name}</option>`);

            // 🔁 Loop for children
            if (category.children && category.children.length > 0) {
                $.each(category.children, function (index, child) {
                    appendCategoryRow(child, level + 1);
                });
            }
        }

        // ➕ Add New Category
        $('#addCategoryBtn').click(function () {
            let name = $('#newCategory').val();
            let parentId = $('#parentCategory').val();

            if (!name) {
                alert('Category name is required!');
                return;
            }

            $.ajax({
                url: '{{ route('categories.store') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    parent_id: parentId
                },
                success: function () {
                    $('#newCategory').val('');
                    loadCategories();
                }
            });
        });

        // ❌ Delete Category
        $(document).on('click', '.deleteCategoryBtn', function () {
            let categoryId = $(this).data('id');

            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: `/categories/${categoryId}`,
                    method: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function () {
                        loadCategories();
                    }
                });
            }
        });

        $(document).on('click', '.selectCategoryBtn', function () {
            let categoryId = $(this).data('id');
            let categoryName = $(this).data('name');

            // ✅ Pilih opsi jika sudah ada, jika tidak, ubah teksnya saja
            let existingOption = $('#categoryDropdown option[value="' + categoryId + '"]');

            if (existingOption.length) {
                // Jika opsi ada, langsung pilih
                $('#categoryDropdown').val(categoryId);
            } else {
                // Jika tidak ada, ganti teks opsi yang dipilih
                $('#categoryDropdown').html(`<option value="${categoryId}">${categoryName}</option>`);
                $('#categoryDropdown').val(categoryId);
            }
            $('.modal-backdrop').remove();


            // 👉 Tutup modal setelah memilih (opsional)
            $('#categoryModal').modal('hide');
        });

    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        loadChargeDepartments();

        document.getElementById("chargeForm").addEventListener("submit", function (event) {
            event.preventDefault();
            const saveButton = document.querySelector("#ChargeModal .btn-outline-success");
            if (saveButton.dataset.mode === "edit") {
                updateChargeDepartment(saveButton.dataset.code);
            } else {
                addChargeDepartment();
            }
        });
    });

    function loadChargeDepartments() {
        fetch("{{ route('account.charge_list') }}")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById("chargeTableBody");
                tableBody.innerHTML = "";
                data.forEach(item => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.description || "-"}</td>
                        <td>${item.facility || "-"}</td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="selectCharge('${item.id}', '${item.description}')">Pilih</button>
                            <button class="btn btn-sm btn-warning" onclick="editCharge('${item.id}', '${item.description}', '${item.facility}')">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteCharge('${item.id}')">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error("Error fetching charge departments:", error));
    }

    function addChargeDepartment() {
        const chargeCode = document.getElementById("chargeCode").value.trim();
        const chargeDescription = document.getElementById("chargeDescription").value.trim();
        const chargeFacility = document.getElementById("chargeFacility").value;

        if (!chargeCode || !chargeDescription) {
            alert("Semua field harus diisi!");
            return;
        }

        fetch("{{ route('account.charge_store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code: chargeCode, description: chargeDescription, facility: chargeFacility })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resetForm();
                    loadChargeDepartments();
                    closeModal();
                } else {
                    alert("Gagal menambahkan data!");
                }
            })
            .catch(error => console.error("Error adding charge department:", error));
    }

    function editCharge(code, description, facility) {
        document.getElementById("chargeCode").value = code;
        document.getElementById("chargeDescription").value = description;
        document.getElementById("chargeFacility").value = facility;

        const saveButton = document.querySelector("#ChargeModal .btn-outline-success");
        saveButton.textContent = "Update";
        saveButton.dataset.mode = "edit";
        saveButton.dataset.code = code;

        $("#ChargeModal").modal("show");
    }

    function deleteCharge(code) {
        if (!confirm("Yakin ingin menghapus charge department ini?")) return;

        fetch("{{ route('account.charge_delete', ':code') }}".replace(":code", code), {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadChargeDepartments();
                } else {
                    alert("Gagal menghapus data!");
                }
            })
            .catch(error => console.error("Error deleting charge department:", error));
    }

    function selectCharge(code, description) {
        const selectElement = document.getElementById("chargemanagement");
        selectElement.innerHTML = '<option value="">-- Select Charge Department --</option>';

        const option = document.createElement("option");
        option.value = code;
        option.textContent = description;
        option.selected = true;

        selectElement.appendChild(option);


        closeModal();
    }

    function resetForm() {
        document.getElementById("chargeForm").reset();
        const saveButton = document.querySelector("#ChargeModal .btn-outline-success");
        saveButton.textContent = "Save";
        saveButton.dataset.mode = "add";
        delete saveButton.dataset.code;
    }

    function closeModal() {
        $("#ChargeModal").modal("hide");
        $('.modal-backdrop').remove();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const partSelect = document.getElementById("partInput");
        const partQtyInput = document.getElementById("partQty");
        const addPartBtn = document.getElementById("addPartBtn");
        const partsTableBody = document.querySelector("#partsTable tbody");
        const modalElement = document.getElementById("addPartModal");
        const bomSelect = document.getElementById("bomSelect");
        const saveBOMBtn = document.getElementById("saveBOMBtn");

        let partIndex = 0; // Untuk tracking index array input

        // Load data dari API ke dalam select option untuk part
        function loadParts() {
            fetch("{{ route('bom.getDataAsset') }}")
                .then(response => response.json())
                .then(responseData => {
                    partSelect.innerHTML = '<option value="">Select a part</option>';
                    responseData.forEach(part => {
                        let option = document.createElement("option");
                        option.value = part.id;
                        option.textContent = part.nameParts;
                        option.dataset.boms = JSON.stringify(part.boms);
                        partSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error fetching parts:", error);
                    partSelect.innerHTML = '<option value="">Failed to load data</option>';
                });
        }

        // Load data BOMs ke dalam select dropdown
        function loadBOMs() {
            fetch("{{ route('asset.listBom') }}")
                .then(response => response.json())
                .then(data => {
                    bomSelect.innerHTML = '<option value="">Select a BOM</option>';
                    data.forEach(bom => {
                        let option = document.createElement("option");
                        option.value = bom.id;
                        option.textContent = bom.name;
                        bomSelect.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching BOMs:", error));
        }

        // Panggil fungsi loadParts() dan loadBOMs() saat halaman dimuat
        loadParts();
        loadBOMs();

        // Event listener untuk tombol "Add Part" (menggunakan input part & qty manual)
        addPartBtn.addEventListener("click", function () {
            let selectedPartText = partSelect.options[partSelect.selectedIndex].text;
            let selectedPartValue = partSelect.value;
            let quantity = partQtyInput.value;

            if (!selectedPartValue) {
                alert("Please select a part!");
                return;
            }

            let bomsData = partSelect.options[partSelect.selectedIndex].dataset.boms;
            let boms = JSON.parse(bomsData);
            let bomControl = (boms && boms.length > 0) ? boms[0].name : "";

            let newRow = `
                <tr data-index="${partIndex}">
                    <td>
                        ${selectedPartText}
                        <input type="hidden" name="part[${partIndex}][name]" value="${selectedPartText}">
                    </td>
                    <td>
                        ${quantity}
                        <input type="hidden" name="part[${partIndex}][quantity]" value="${quantity}">
                    </td>
                    <td>
                        ${bomControl}
                        <input type="hidden" name="part[${partIndex}][bom_control]" value="${bomControl}">
                    </td>
                    <td>
                        ${quantity}
                        <input type="hidden" name="part[${partIndex}][qty_on_hand]" value="${quantity}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                    </td>
                </tr>`;

            partsTableBody.innerHTML += newRow;
            partIndex++;

            // Reset form
            partSelect.value = "";
            partQtyInput.value = "1";

            // Tutup modal setelah menambahkan
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            $('.modal-backdrop').remove();
            if (modalInstance) modalInstance.hide();
        });

        // Event listener untuk tombol "Save BOM" (menggunakan select BOM)
        saveBOMBtn.addEventListener("click", function () {
            let selectedBOMValue = bomSelect.value;
            if (!selectedBOMValue) {
                alert("Please select a BOM!");
                return;
            }

            // Lakukan fetch ke endpoint asset.getpartBom dengan parameter BOM ID
            fetch("{{ route('asset.getpartBom') }}?bom_id=" + selectedBOMValue)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    // Data diharapkan berisi: partName, quantity, bomControl, qtyOnHand
                    let newRow = `
                        <tr data-index="${partIndex}">
                            <td>
                                ${data[0].parts[0].nameParts}
                                <input type="hidden" name="part[${partIndex}][name]" value="${data.partName}">
                            </td>
                            <td>
                                ${data.quantity}
                                <input type="hidden" name="part[${partIndex}][quantity]" value="${data.quantity}">
                            </td>
                            <td>
                                ${data.bomControl}
                                <input type="hidden" name="part[${partIndex}][bom_control]" value="${data.bomControl}">
                            </td>
                            <td>
                                ${data.qtyOnHand}
                                <input type="hidden" name="part[${partIndex}][qty_on_hand]" value="${data.qtyOnHand}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </td>
                        </tr>`;
                    partsTableBody.innerHTML += newRow;
                    partIndex++;

                    // Reset dropdown setelah menyimpan
                    bomSelect.value = "";
                })
                .catch(error => console.error("Error fetching BOM details:", error));
        });

        // Event listener untuk tombol Delete pada table
        partsTableBody.addEventListener("click", function (event) {
            if (event.target.classList.contains("delete-btn")) {
                event.target.closest("tr").remove();
            }
        });
    });
</script>


        <script>
            $(document).ready(function () {
                function updateIndexes() {
                    $('#personnelTable tbody tr').each(function (index) {
                        $(this).find('input[name^="personnel_id"]').attr('name', `personnel_id[${index}]`);
                        $(this).find('input[name^="personnel_name"]').attr('name', `personnel_name[${index}]`);
                        $(this).find('input[name^="personnel_type"]').attr('name', `personnel_type[${index}]`);
                    });
                }

                // Show Modals
                $('#addPersonnelBtn').click(function () {
                    $('#addPersonnelModal').modal('show');
                });

                $('#addGroupBtn').click(function () {
                    $('#addGroupModal').modal('show');
                });

                // Save Personnel
                $('#savePersonnelBtn').click(function () {
                    $('#selectUser option:selected').each(function () {
                        let id = $(this).val();
                        let name = $(this).data('name');
                        let type = $(this).data('type');

                        if (id) {
                            $('#personnelTable tbody').append(`
                     <tr>
                        <td><input type="hidden" name="personnel_id[]" value="${id}">
                            <input type="text" class="form-control" name="personnel_name[]" value="${name}" readonly></td>
                        <td><input type="text" class="form-control" name="personnel_type[]" value="${type}" readonly></td>
                        <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                    </tr>
                `);
                            updateIndexes(); // Perbarui index setelah menambahkan baris baru
                        }
                    });

                    $('#addPersonnelModal').modal('hide');
                    $('#selectUser').val('');
                });

                // Save Group
                $('#saveGroupBtn').click(function () {
                    $('#selectGroup option:selected').each(function () {
                        let id = $(this).val();
                        let name = $(this).data('name');
                        let type = $(this).data('type');

                        if (id) {
                            $('#personnelTable tbody').append(`
                     <tr>
                        <td><input type="hidden" name="personnel_id[]" value="${id}">
                            <input type="text" class="form-control" name="personnel_name[]" value="${name}" readonly></td>
                        <td><input type="text" class="form-control" name="personnel_type[]" value="${type}" readonly></td>
                        <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                    </tr>
                `);
                            updateIndexes(); // Perbarui index setelah menambahkan baris baru
                        }
                    });

                    $('#addGroupModal').modal('hide');
                    $('#selectGroup').val('');
                });

                // Remove row
                $(document).on('click', '.removeRow', function () {
                    $(this).closest('tr').remove();
                    updateIndexes(); // Perbarui index setelah menghapus baris
                });
            });

        </script>


<script>
    let fileIndex = 0;
    let uploadedFiles = {};

    function showModal() {
        var type = document.getElementById("typefile").value;
        var modalContent = document.getElementById("modalContent");

        if (!type) {
            alert("Please select a type first!");
            return;
        }

        let inputHTML = '';
        if (type === "file") {
            inputHTML = `<label for="fileInput">Select File</label>
                         <input type="file" id="fileInput" class="form-control">`;
        } else if (type === "note") {
            inputHTML = `<label for="noteName">Name</label>
                         <input type="text" id="noteName" class="form-control" placeholder="Enter name">
                         <label for="noteContent" class="mt-2">Note</label>
                         <textarea id="noteContent" class="form-control" placeholder="Enter note"></textarea>`;
        } else if (type === "link") {
            inputHTML = `<label for="linkName">Name</label>
                         <input type="text" id="linkName" class="form-control" placeholder="Enter name">
                         <label for="linkUrl" class="mt-2">Link</label>
                         <input type="url" id="linkUrl" class="form-control" placeholder="Enter link">
                         <label for="linkNote" class="mt-2">Note</label>
                         <textarea id="linkNote" class="form-control" placeholder="Enter note"></textarea>`;
        }

        modalContent.innerHTML = inputHTML;
        $("#fileModal").modal("show");
    }

    function saveData() {
        var type = document.getElementById("typefile").value;
        var tableBody = document.getElementById("fileTableBody");
        var newRow = document.createElement("tr");
        let name, size = "-", modified = new Date().toLocaleString();
        let fileURL = "";

        if (type === "file") {
            var fileInput = document.getElementById("fileInput");
            if (fileInput.files.length === 0) {
                alert("Please select a file.");
                return;
            }
            var file = fileInput.files[0];
            name = file.name;
            size = (file.size / 1024).toFixed(2) + " KB";
            fileURL = URL.createObjectURL(file);
        } else if (type === "note") {
            name = document.getElementById("noteName").value;
            let noteContent = document.getElementById("noteContent").value;
            if (!name.trim()) {
                alert("Please enter a name for the note.");
                return;
            }
            let noteBlob = new Blob([noteContent], { type: "text/plain" });
            fileURL = URL.createObjectURL(noteBlob);
        } else if (type === "link") {
            name = document.getElementById("linkName").value;
            fileURL = document.getElementById("linkUrl").value;
            if (!name.trim()) {
                alert("Please enter a name for the link.");
                return;
            }
        }

        newRow.innerHTML = `
        <td><input type="text" name="files[${fileIndex}][name]" value="${name}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][type]" value="${type}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][size]" value="${size}" readonly class="form-control"></td>
        <td><input type="text" name="files[${fileIndex}][modified]" value="${modified}" readonly class="form-control"></td>
        <td>
            <button class="btn btn-info" onclick="downloadFile('${fileURL}', '${type}')">Download</button>
            <button class="btn btn-danger" onclick="deleteRow(this)">Delete</button>
        </td>
        `;

        tableBody.appendChild(newRow);
        fileIndex++;
        $("#fileModal").modal("hide");
    }

    function deleteRow(button) {
        button.closest("tr").remove();
    }

    function downloadFile(fileURL, type) {
        if (type === "link") {
            window.open(fileURL, "_blank");
        } else {
            let a = document.createElement("a");
            a.href = fileURL;
            a.download = "download";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector(".btnsubmitall").addEventListener("click", function () {
            let formData = {};

            // Ambil semua input, select, dan textarea dalam form
            document.querySelectorAll("#facility-form input, #facility-form select, #facility-form textarea").forEach(element => {
                if (element.type === "checkbox") {
                    formData[element.name] = element.checked ? 1 : 0;
                } else if (element.type === "radio") {
                    if (element.checked) {
                        formData[element.name] = element.value;
                    }
                } else {
                    formData[element.name] = element.value;
                }
            });

            console.log(formData); // Debugging: Lihat hasil di console sebelum dikirim ke server

            // Kirim data ke Laravel via AJAX (Opsional)
            fetch("{{ route('asset.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    console.log("Raw response:", response); // Debugging: Lihat response sebelum parsing JSON
                    return response.text(); // Ambil teks response dulu
                })
                .then(text => {
                    console.log("Raw text response:", text); // Debugging: Lihat isi response
                    return JSON.parse(text); // Parse ke JSON
                })
                .then(data => {
                    if(data.success) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Data saved successfully!',
                        })
                        .then(() => {
                            console.log(data);
                            {{--window.location.href = "{{ route('asset.list') }}";--}}
                        });
                    }else{
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to save data. Please try again.',
                        })
                    }
                })
                .catch(error => console.error("Error:", error));

        });
    });

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("meterReadingForm").addEventListener("submit", function (event) {
            event.preventDefault();
            addMeterReading();
        });
    });

    function addMeterReading() {
        const meterReading = document.getElementById("meterReading").value.trim();
        const meterReadingUnit = document.getElementById("meterReadingUnit").value;
        const submittedBy = document.getElementById("submittedBy").value;
        const submittedDate = new Date().toLocaleString();

        if (meterReading === "") {
            alert("Meter reading is required!");
            return;
        }

        const tableBody = document.getElementById("meterReadingTableBody");
        const index = tableBody.children.length; // Index untuk input hidden

        const newRow = `
            <tr>
                <td>${meterReading} <input type="hidden" name="meterReading[${index}]" value="${meterReading}"></td>
                <td>${meterReadingUnit} <input type="hidden" name="meterReadingUnit[${index}]" value="${meterReadingUnit}"></td>
                <td>${submittedDate} <input type="hidden" name="submittedDate[${index}]" value="${submittedDate}"></td>
                <td>${submittedBy} <input type="hidden" name="submittedBy[${index}]" value="${submittedBy}"></td>
                <td>${submittedDate}</td>
            </tr>
        `;

        // Menambahkan baris di posisi teratas (sebelum baris pertama)
        tableBody.insertAdjacentHTML("afterbegin", newRow);

        document.getElementById("meterReadingForm").reset();
        document.getElementById("submittedDate").value = submittedDate;
        $("#meterReadingModal").modal("hide");
        $('body').removeAttr('style');
        $('.modal-backdrop').remove();
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", async function () {
        const locationSelect = document.getElementById("locationSelect");
        const locationInfo = document.getElementById("locationname");

        try {
            const response = await fetch("{{ route('asset.getFacilities') }}");
            if (!response.ok) throw new Error("Failed to fetch locations");

            const data = await response.json();
            data.forEach(location => {
                const option = document.createElement("option");
                option.value = location.id;
                option.textContent = location.name;
                locationSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching locations:", error);
        }

        // Event listener untuk update lokasi dengan AJAX
        locationSelect.addEventListener("change", async function () {
            const selectedId = locationSelect.value;
            if (!selectedId) {
                locationInfo.innerHTML = "<em>Please select a location.</em>";
                return;
            }
            try {
                const response = await fetch("{{ route('asset.getLocationDetails') }}?id=" + selectedId);
                if (!response.ok) throw new Error("Failed to fetch location details");

                const result = await response.json();
                if (result.status === "error") {
                    locationInfo.innerHTML = "<em>Location not found.</em>";
                    return;
                }
                const locationData = result.data;
                locationInfo.innerHTML = `
                    <strong>Address:</strong> ${locationData.address || "N/A"} <br>
                    <strong>City:</strong> ${locationData.city || "N/A"} <br>
                    <strong>Province:</strong> ${locationData.province || "N/A"} <br>
                    <strong>Country:</strong> ${locationData.country || "N/A"} <br>
                    <strong>Postal Code:</strong> ${locationData.postal_code || "N/A"}
                `;
            } catch (error) {
                console.error("Error fetching location details:", error);
                locationInfo.innerHTML = "<em>-</em>";
            }
        });
    });
</script>

<script>
    $(document).on('hidden.bs.modal', function () {
        setTimeout(() => {
            $('body').removeAttr('style');
        }, 100); // Delay kecil untuk memastikan modal sudah ditutup
    });
</script>
