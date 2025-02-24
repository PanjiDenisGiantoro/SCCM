@extends('layout.layout2')

@php
    $title = 'Equipment';
    $subTitle = 'Equipment';
@endphp

@section('content')

    <script src="https://cdn.tailwindcss.com">
    </script>
    <body class="bg-gray-100 p-4">
    <div class="bg-white p-6 rounded-lg shadow-md">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header flex items-center justify-between">
                    <h6 class="card-title mb-0">Equipment Form</h6>
                    <button class="btn btn-primary">Submit Form</button>

                </div>
               <div class="card-body">
                   <div class="flex items-center justify-between mb-4">
                       <h1 class="text-xl font-semibold">
                           Equipment: New Equipment #A125 (A125)
                       </h1>
                       <div class="flex items-center space-x-2">
                           <div class="form-check form-switch">
                               <input class="form-check-input" type="checkbox" id="onlineSwitch" checked>
                               <label class="form-check-label" for="onlineSwitch" id="onlineLabel">Online</label>
                           </div>
                           <img alt="QR code" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/v5qFCNd9uq5cljAjtGR7fNot_RK5nsPH8kt_5VAhyL0.jpg" width="50"/>

                       </div>
                   </div>
               </div>
                <div class="card-body">
                    <div class="flex items-start space-x-4 mb-4">
                        <img alt="Facility image" class="w-24 h-24" height="100" src="https://storage.googleapis.com/a1aa/image/HFJxqkWxAyQap8WAGrQ1CiUPcKoc3C2lpUtmuY5gYZE.jpg" width="100"/>
                        <div class="flex-1">
                            <div class="mb-2">
                                <label class="block text-gray-700">
                                    New Equipment #A124
                                </label>
                                <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                            </div>
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <label class="block text-gray-700">
                                        Code
                                    </label>
                                    <input class="w-full border border-gray-300 rounded-lg p-2" type="text" value="A124"/>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-gray-700">
                                        Category
                                    </label>
                                    <select class="w-full border border-gray-300 rounded-lg p-2">
                                        <option>
                                            Equipment
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts" type="button" role="tab" aria-controls="parts" aria-selected="false">Parts/BOM <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="metering-tab" data-bs-toggle="tab" data-bs-target="#metering" type="button" role="tab" aria-controls="metering" aria-selected="false">Metering/Events <span class="badge bg-gray-200 text-gray-700">2</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="personnel-tab" data-bs-toggle="tab" data-bs-target="#personnel" type="button" role="tab" aria-controls="personnel" aria-selected="false">Personnel <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
{{--                        warranties--}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="warranties-tab" data-bs-toggle="tab" data-bs-target="#warranties" type="button" role="tab" aria-controls="warranties" aria-selected="false">warranties <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>{{--                        warranties--}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="bussiness-tab" data-bs-toggle="tab" data-bs-target="#bussiness" type="button" role="tab" aria-controls="bussiness" aria-selected="false">bussiness <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>{{--                        warranties--}}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="purchasing-tab" data-bs-toggle="tab" data-bs-target="#purchasing" type="button" role="tab" aria-controls="purchasing" aria-selected="false">purchasing <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">Files <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="financials-tab" data-bs-toggle="tab" data-bs-target="#financials" type="button" role="tab" aria-controls="financials" aria-selected="false">Financials <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false">Log <span class="badge bg-gray-200 text-gray-700">6</span></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="mb-4">
                                <h2 class="text-lg font-semibold mb-2">Location</h2>
                                <div class="mb-2">
                                    <input checked class="mr-2" id="partOf" name="location" type="radio"/>
                                    <label class="text-gray-700" for="partOf">This facility is a part of:</label>
                                    <select class="border border-gray-300 rounded-lg p-2 ml-2">
                                        <option>Data Centre Bekasi (DC01)</option>
                                    </select>
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg ml-2">Show On Map</button>
                                </div>
                                <div class="ml-6 mb-2">
                                    <p class="text-gray-700">Jl. Indonesia Raya, Bekasi, Jawa barat, 17426, Indonesia, Republic of</p>
                                    <div class="d-flex align-items-center">
                                        <input checked class="mr-2" id="useAddress" type="checkbox"/>
                                        <label class="text-gray-700" for="useAddress">Use This address (uncheck to use different address below)</label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <input class="mr-2" id="notPartOf" name="location" type="radio"/>
                                    <label class="text-gray-700" for="notPartOf">This facility is not part of another location, and is located at:</label>
                                </div>
                                <div class="ml-6">
                                    <div class="mb-2">
                                        <label class="block text-gray-700">Address</label>
                                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                    </div>
                                    <div class="d-flex space-x-4 mb-2">
                                        <div class="flex-1">
                                            <label class="block text-gray-700">City</label>
                                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-700">Province</label>
                                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                        </div>
                                    </div>
                                    <div class="d-flex space-x-4 mb-2">
                                        <div class="flex-1">
                                            <label class="block text-gray-700">Postal Code</label>
                                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-gray-700">Country</label>
                                            <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold mb-2">General Information</h2>
                                <div class="d-flex space-x-4">
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Account</label>
                                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Barcode</label>
                                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                    </div>

                                </div>
                                <div class="d-flex space-x-4">
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Charge Department</label>
                                        <input class="w-full border border-gray-300 rounded-lg p-2" type="text"/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-gray-700">Note</label>
                                        <textarea class="w-full border border-gray-300 rounded-lg p-2 h-40" type="text"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="parts" role="tabpanel" aria-labelledby="parts-tab">
                            <div class="card-body">
                                <div class="mb-4">
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Add Part</button>
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add BOM Group</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0 ">
                                        <thead>
                                        <tr>
                                            <th>Part</th>
                                            <th>Quantity</th>
                                            <th>BOM Control</th>
                                            <th>Qty On Hand</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="form-control" type="text" value="CPU"></td>
                                            <td><input class="form-control" type="text" value="1"></td>
                                            <td><input class="form-control" type="text" ></td>
                                            <td><input class="form-control" type="text" value="1"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Parts/BOM content goes here -->
                        </div>
                        <div class="tab-pane fade" id="metering" role="tabpanel" aria-labelledby="metering-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body ">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                            <h6 class="text-lg fw-semibold mb-0">Most Recent Meter Reading</h6>
                                            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Meter Reading</button>
                                            </div>
                                        </div>
                                    <div class="table-responsive">
                                        <table class="table basic-table mb-0">
                                            <thead>
                                            <tr>
                                                <th>Last Reading</th>
                                                <th>Unit</th>
                                                <th>Date Submitted</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Hours (h)</td>
                                                <td>Feb 22, 2023 8:00 AM</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card-body ">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-lg fw-semibold mb-0">Most Recent Asset Events</h6>
                                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Asset Event</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Event</th>
                                                    <th>Date Submitted</th>
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
                        </div>
                        </div>

                        <div class="tab-pane fade" id="warranties" role="tabpanel" aria-labelledby="warranties-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body ">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-lg fw-semibold mb-0">Warranties</h6>
                                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Warranty</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Date Added</th>
                                                    <th>Expiry Date</th>
                                                    <th>Certificate Number</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Feb 22, 2023 8:00 AM</td>
                                                    <td>Feb 23, 2023 8:00 AM</td>
                                                    <td>12345</td>
                                                    <td>
                                                        <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Delete</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="bussiness" role="tabpanel" aria-labelledby="bussiness-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body ">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-lg fw-semibold mb-0">Bussiness </h6>
                                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Bussiness</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Business Type</th>
                                                    <th>Business Name</th>
                                                    <th>Business Asset Number</th>
                                                    <th>Catalog</th>
                                                    <th>Vendor Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        Owner
                                                    </td>
                                                    <td>
                                                        John Doe
                                                    </td>
                                                    <td>
                                                        12345
                                                    </td>
                                                    <td>
                                                        Catalog 1
                                                    </td>
                                                    <td>
                                                        $100
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="personnel" role="tabpanel" aria-labelledby="personnel-tab">
                            <div class="card-body">
                                <div class="mb-4">
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Add Personnel</button>
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Personnel Group</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Role</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>John Doe</td>
                                            <td>Group A</td>
                                            <td>Manager</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                            <!-- Files content goes here -->
                            <div class="card-body">
                                <div class="mb-4">
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Add File</button>
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add Folder</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Modified</th>
                                            <th>action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>File 1</td>
                                            <td>PDF</td>
                                            <td>1.2 MB</td>
                                            <td>Feb 22, 2023 8:00 AM</td>
                                            <td>
                                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Download</button>
                                                <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Delete</button>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="financials" role="tabpanel" aria-labelledby="financials-tab">
                            <!-- Financials content goes here -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                    <table class="table basic-table mb-0">
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
                                    <table class="table basic-table mb-0">
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
                            <!-- Log content goes here -->
                            <div class="row">
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Schedule Maintenance
                                            </h6>
                                            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Add Log</button>

                                        </div>
                                    </div>
                                    <div class="card-body ">
                                    <div class="table-responsive">
                                    <table class="table basic-table mb-0">
                                        <thead>
                                        <tr>
                                            <th>When</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Shedule Status</th>
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
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Open Work Orders
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
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
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Work Orders History
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
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
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                               Part Supply Consummed
                                            </h6>

                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
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
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Work Order Log
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Log Date</th>
                                                    <th>Inventory Cost</th>
                                                    <th>Completion Notes</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        Feb 22, 2023 8:00 AM
                                                    </td>
                                                    <td>
                                                        1000
                                                    </td>
                                                    <td>
                                                        <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">View</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Asset Offline Tracker
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
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
                                                    <td>
                                                        Feb 22, 2023 8:00 AM
                                                    </td>
                                                    <td>
                                                        Feb 23, 2023 8:00 AM
                                                    </td>
                                                    <td>
                                                        Technisian
                                                    </td>
                                                    <td>
                                                    Engineer
                                                    </td>
                                                    <td>
                                                        8 hours
                                                    </td>
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

            </div>
            </div><!-- card end -->
        </div>
    </div>
    </div>
    </body>

    <div class="modal fade" id="offline" tabindex="-1" aria-labelledby="offlineLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offline">SET OFFLINE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Offline From</label>
                            <input type="text" class="w-full border border-gray-300 rounded-md p-2"
                                   value="Feb 18, 2025 05:04:00 PM">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Set Offline By User</label>
                            <select class="w-full border border-gray-300 rounded-md p-2">
                                <option>Kevin Adisaputra</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select class="w-full border border-gray-300 rounded-md p-2">
                                <option></option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Associated Work Order</label>
                            <select class="w-full border border-gray-300 rounded-md p-2">
                                <option></option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Info</label>
                            <textarea class="w-full border border-gray-300 rounded-md p-2"></textarea>
                        </div>
                        <h3 class="text-sm font-semibold mb-2">Generate Asset Event</h3>
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2 text-sm font-medium text-gray-700">Generate an event</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Event Type</label>
                            <select class="w-full border border-gray-300 rounded-md p-2">
                                <option></option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Event Description</label>
                            <textarea class="w-full border border-gray-300 rounded-md p-2"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="online" tabindex="-1" aria-labelledby="onlineLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-primary">Save changes</button>
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
        $('#onlineSwitch').change(function() {
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

