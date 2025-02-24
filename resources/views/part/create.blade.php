@extends('layout.layout2')

@php
    $title = 'Part and Supplier';
    $subTitle = 'Part and Supplier';
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
                            <button class="nav-link active" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button" role="tab" aria-controls="stock" aria-selected="false">Stock <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts" type="button" role="tab" aria-controls="parts" aria-selected="false">BOMs <span class="badge bg-gray-200 text-gray-700">3</span></button>
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
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">Files <span class="badge bg-gray-200 text-gray-700">3</span></button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false">Log <span class="badge bg-gray-200 text-gray-700">6</span></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="parts" role="tabpanel" aria-labelledby="parts-tab">
                            <div class="card-body">
                                <div class="mb-4">
                                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Add BOM Group</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table basic-table mb-0 ">
                                        <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>BOM Control</th>
                                            <th>Asset</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input class="form-control" type="text" value="1"></td>
                                            <td><input class="form-control" type="text" ></td>
                                            <td><input class="form-control" type="text" value="CPU"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Parts/BOM content goes here -->
                        </div>

                        <div class="tab-pane fade active show" id="stock" role="tabpanel" aria-labelledby="stock-tab">
                            <div class="row">
                                <div class="col-md-6 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Stock Levels per Location
                                            </h6>
                                            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">Add Log</button>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Location</th>
                                                    <th>Aisle</th>
                                                    <th>Row</th>
                                                    <th>Bin</th>
                                                    <th>Qty On Hand</th>
                                                    <th>Min Qty</th>
                                                    <th>Max Qty</th>
                                                </tr>

                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Receipt
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Qty Ordered</th>
                                                    <th>Qty Received</th>
                                                    <th>Date Received</th>
                                                    <th>Receipt #</th>
                                                    <th>Supplier</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-1 radius-4 ">
                                    <div class="card-header">
                                        <div class="mb-4">
                                            <h6>
                                                Open POs
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="table basic-table mb-0">

                                                <thead>
                                                <tr>
                                                   <th>Qty On Order</th>
                                                    <th>Purchase Order Status</th>
                                                    <th>Purchase Order Id</th>
                                                    <th>Supplier</th>
                                                </tr>

                                                </thead>
                                                <tbody>

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

