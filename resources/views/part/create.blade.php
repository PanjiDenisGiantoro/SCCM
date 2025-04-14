@extends('layout.layout2')

@php
    if(!empty($partdata)){

        $title = 'Edit Part and Supplier';
        $subTitle = 'Edit Part and Supplier';
    }else{
        $title = 'Part and Supplier';
        $subTitle = 'Part and Supplier';
    }
@endphp

@section('content')
    <style>
        span {
            display: inline;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <div id="submitform">
        <div class="row gy-4">
            <div class="col-lg-9">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Part and Supplier Form</h6>
                        <button type="button" id="submitformbutton" class="btn btn-outline-success">Submit Form</button>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <h1 class="h5 font-weight-bold">
                                New Part
                            </h1>
                            <div class="d-flex align-items-center">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex  mb-4">
                                    <div class="flex-grow-1 ms-3    ">
                                        <div class="mb-2">
                                            <label class="form-label">Name Part</label>
                                            <input class="form-control" type="text" name="namepart"
                                                   @if(!empty($partdata)) value="{{$partdata->nameParts}}" @endif
                                            />
                                        </div>
                                        <label class="form-label">Category</label>
                                        <div class="input-group">
                                            <select class="form-select" id="categoryDropdown" name="categorypart">
                                                @if(!empty($partdata))
                                                    <option
                                                        value="{{$partdata->category}}">{{$partdata->categories->category_name ?? ''}}</option>
                                                @else
                                                    <option value="">-- Select Category --</option>
                                                @endif
                                            </select>
                                            <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                    data-bs-target="#categoryModal">Manage
                                            </button>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Charge Department</label>
                                <div class="input-group">
                                    <select class="form-select" id="chargemanagement"
                                            name="id_charge">
                                        @if(!empty($partdata))
                                            <option
                                                value="{{$partdata->id_charge}}">{{$partdata->charge->name ?? ''}}</option>
                                        @else
                                            <option value="">-- Select Charge Department --</option>
                                        @endif
                                    </select>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#ChargeModal">
                                        Manage
                                    </button>
                                </div>
                                <label class="form-label">Account</label>
                                <div class="input-group">
                                    <select class="form-select" id="accountInput" name="id_account">
                                        @if(!empty($partdata))
                                            <option
                                                value="{{$partdata->id_account}}">{{$partdata->accounts->name ?? ''}}</option>
                                        @else
                                            <option value="">-- Select Account --</option>
                                        @endif
                                    </select>
                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#accountModal">Manage
                                    </button>
                                </div>
                                <div class="modal fade" id="ChargeModal" tabindex="-1"
                                     aria-labelledby="ChargeModalLabel" aria-hidden="true">
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
                                                        <label for="chargeDescription"
                                                               class="form-label">Description</label>
                                                        <input type="text" class="form-control"
                                                               id="chargeDescription" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="chargeFacility"
                                                               class="form-label">Facility</label>
                                                        <select class="form-select " id="chargeFacility"
                                                                required>
                                                            <option value="">-- Select Facility --</option>
                                                            @foreach($facility as $faci)
                                                                <option
                                                                    value="{{ $faci->id }}">{{ $faci->name }}</option>
                                                            @endforeach
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

                            </div>
                            <div class="modal fade" id="accountModal" tabindex="-1"
                                 aria-labelledby="accountModalLabel" aria-hidden="true">
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
                                                <button class="btn btn-outline-info" onclick="addAccount()">
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


                        </div>
                        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel"
                             aria-hidden="true">
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
                                            <button class="btn btn-outline-success ms-2" id="addCategoryBtn">Add
                                            </button>
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
                            <ul class="nav nav-tabs mb-4bg-gray-200" id="myTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="stock-tab" data-bs-toggle="tab"
                                            data-bs-target="#stock"
                                            type="button" role="tab" aria-controls="stock" aria-selected="false">Stock
                                        <span
                                            class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="parts-tab" data-bs-toggle="tab" data-bs-target="#parts"
                                            type="button" role="tab" aria-controls="parts" aria-selected="false">BOMs
                                        <span
                                            class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="personnel-tab" data-bs-toggle="tab"
                                            data-bs-target="#personnel"
                                            type="button" role="tab" aria-controls="personnel" aria-selected="false">
                                        Personnel
                                        <span class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>
                                {{--                        warranties--}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="warranties-tab" data-bs-toggle="tab"
                                            data-bs-target="#warranties" type="button" role="tab"
                                            aria-controls="warranties"
                                            aria-selected="false">warranties <span
                                            class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>{{--                        warranties--}}
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="bussiness-tab" data-bs-toggle="tab"
                                            data-bs-target="#bussiness"
                                            type="button" role="tab" aria-controls="bussiness" aria-selected="false">
                                        bussiness
                                        <span class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>{{--                        warranties--}}

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files"
                                            type="button" role="tab" aria-controls="files" aria-selected="false">Files
                                        <span
                                            class="badge bg-gray-200 text-gray-700">3</span></button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log"
                                            type="button" role="tab" aria-controls="log" aria-selected="false">Log <span
                                            class="badge bg-gray-200 text-gray-700">6</span></button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade" id="parts" role="tabpanel" aria-labelledby="parts-tab">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <button class="btn btn-outline-success mt-3" data-bs-toggle="modal"
                                                    data-bs-target="#addBOMModal">Add BOM
                                            </button>

                                        </div>


                                        <!-- Modal Add BOM -->
                                        <div class="modal fade" id="addBOMModal" tabindex="-1"
                                             aria-labelledby="addBOMModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addBOMModalLabel">Add BOM</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="bomForm">
                                                            <div class="mb-3">
                                                                <label for="partName" class="form-label">Select
                                                                    Part</label>
                                                                <select class="form-select" id="partName">
                                                                    <option value="">-- Select Part --</option>
                                                                    @foreach($parts as $part)
                                                                        <option
                                                                            value="{{ $part->id }}">{{ $part->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="quantity"
                                                                       class="form-label">Quantity</label>
                                                                <input type="number" class="form-control" id="quantity"
                                                                       value="1" min="1">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bomControl" class="form-label">BOM
                                                                    Control</label>
                                                                <input type="text" class="form-control" id="bomControl">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel
                                                        </button>
                                                        <button type="button" class="btn btn-outline-success"
                                                                onclick="addBOMRow()">Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Table -->
                                        <div class="table-responsive mt-3">
                                            <table class="table basic-table mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>BOM Control</th>
                                                    <th>Asset</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="bomTableBody">
                                                <!-- Data akan ditambahkan di sini -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="bomDataInput" name="bomData" value="[]">


                                    </div>
                                    <!-- Parts/BOM content goes here -->
                                </div>

                                <div class="tab-pane fade active show" id="stock" role="tabpanel"
                                     aria-labelledby="stock-tab">
                                    <div class="row">
                                        <div class="col-md-12 border-1 radius-4">
                                            <div class="card-header">
                                                <div class="mb-4 d-flex justify-content-between align-items-center">
                                                    <h6>Stock Levels per Location</h6>
                                                    <button class="btn btn-outline-success" data-bs-toggle="modal"
                                                            data-bs-target="#addStockModal">
                                                        Add Log
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
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
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="stockTableBody">
                                                        <!-- Data akan ditambahkan di sini -->
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="adjustStockModal" tabindex="-1"
                                             aria-labelledby="adjustStockModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="adjustStockModalLabel">Adjust
                                                            Stock</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="adjustStockForm">
                                                            <input type="hidden" id="editRowIndex">

                                                            <!-- Tampilkan Data Sebelumnya (tanpa Status) -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Location:</label>
                                                                <span id="editLocation"></span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Aisle:</label>
                                                                <span id="editAisle"></span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Row:</label>
                                                                <span id="editRow"></span>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Bin:</label>
                                                                <span id="editBin"></span>
                                                            </div>

                                                            <!-- Qty On Hand Adjustment -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Qty On Hand:</label>
                                                                <input type="number" class="form-control"
                                                                       id="editQtyOnHand">
                                                            </div>

                                                            <button type="button" class="btn btn-outline-success"
                                                                    id="saveAdjustment">Save Adjustment
                                                            </button>
                                                        </form>

                                                        <!-- Stock Log -->
                                                        <div class="mt-4">
                                                            <h6>Stock Log</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>User</th>
                                                                        <th>Description</th>
                                                                        <th>Qty Before</th>
                                                                        <th>Qty After</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="logTableBody">
                                                                    <!-- Log akan ditampilkan di sini -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="addStockModal" tabindex="-1"
                                             aria-labelledby="addStockModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addStockModalLabel">Add Stock
                                                            Log</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label">Facility</label>
                                                                <select id="facility" class="form-select">
                                                                    @foreach ($facility as $faci)
                                                                        <option
                                                                            value="{{ $faci->id }}">{{ $faci->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Qty On Hand</label>
                                                                <input type="number" id="qtyOnHand"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Min Qty</label>
                                                                <input type="number" id="minQty" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Max Qty</label>
                                                                <input type="number" id="maxQty" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Aisle</label>
                                                                <input type="text" id="aisle" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Row</label>
                                                                <input type="text" id="row" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Bin</label>
                                                                <input type="text" id="bin" class="form-control">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Status</label>
                                                                <select id="status" class="form-select">
                                                                    <option value="Online">Online</option>
                                                                    <option value="Offline">Offline</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button id="addStockBtn" class="btn btn-outline-success mt-3">
                                                            Add
                                                        </button>

                                                        <!-- Log Table -->
                                                        <div class="mt-4">
                                                            <h6>Stock Log</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>User</th>
                                                                        <th>Description</th>
                                                                        <th>Qty Before</th>
                                                                        <th>Qty After</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody id="logTableBody">
                                                                    <!-- Data log akan ditambahkan di sini -->

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 border-1 radius-4 ">
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
                                                            <th>Qty Received</th>
                                                            <th>Date Received</th>
                                                            <th>Receipt #</th>
                                                            <th>Supplier</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(!empty($partdata) && $partdata->receiptbodies->isNotEmpty())
                                                            @php
                                                                $grouped = $partdata->receiptbodies->groupBy(fn($item) => $item->receipt->receipt_number ?? 'unknown');
                                                                  $totalAllReceipt = $grouped->sum(function($group) {
                                                                     return optional($group->first()->receipt)->total ?? 0;
                                                                     });
                                                            @endphp

                                                            @foreach($grouped as $receiptNumber => $group)
                                                                @php
                                                                    $firstBody = $group->first();
                                                                    $totalReceived = $group->sum(fn($item) => (int) $item->received_to);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $totalReceived }}</td>
                                                                    <td>{{ $firstBody->receipt->receipt_date ?? '-' }}</td>
                                                                    <td>{{ $receiptNumber }}</td>
                                                                    <td>{{ $firstBody->receipt->business->business_name ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4">No data found</td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 border-1 radius-4 ">
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
                                                        @if(!empty($partdata) && $partdata->purchasebodies)
                                                            @foreach($partdata->purchasebodies as $po)
                                                                <tr>
                                                                    <td>{{ $po->qty ?? '-' }}</td>
                                                                    <td>
                                                                        @php
                                                                            switch ($po->getpurchaseorder->status ?? null) {
                                                                                case '0': $status = 'Pending'; break;
                                                                                case '1': $status = 'Approved'; break;
                                                                                default: $status = 'Reject'; break;
                                                                            }
                                                                        @endphp
                                                                        {{ $status }}
                                                                    </td>
                                                                    <td>{{ $po->getpurchaseorder->po_number ?? '-' }}</td>
                                                                    <td>{{ $po->getpurchaseorder->business->business_name ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4">No purchase order data found</td>
                                                            </tr>
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="warranties" role="tabpanel"
                                     aria-labelledby="warranties-tab">

                                    <!-- Modal -->
                                    <div class="modal fade" id="addWarrantyModal" tabindex="-1"
                                         aria-labelledby="addWarrantyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addWarrantyModalLabel">Add Warranty</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="warrantyForm">
                                                    <div class="modal-body">
                                                        <h2 class="h5 mb-4">WARRANTY CERTIFICATE</h2>
                                                        <div class="form-group">
                                                            <label>Warranty Type</label>
                                                            <select class="form-control" name="warranties[type][]">
                                                                <option value="basic">Basic</option>
                                                                <option value="extended">Extended</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Provider</label>
                                                            <select class="form-control" name="warranties[provider][]"
                                                                    id="providerSelect">
                                                                <option value="">Loading...</option>

                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Warranty Usage Term Type</label>
                                                            <select class="form-control" name="warranties[usage_term][]"
                                                                    id="usageTerm">
                                                                <option value="">Pilih Usage Term</option>
                                                                <option value="date">Date</option>
                                                                <option value="meter_reading">Meter Reading</option>
                                                                <option value="production_time">Production Time</option>
                                                            </select>
                                                        </div>

                                                        <!-- Input untuk Expiry Date (Hanya muncul jika memilih "Date" atau lainnya) -->
                                                        <div class="form-group" id="expiryDateGroup"
                                                             style="display: none;">
                                                            <label>Expiry Date</label>
                                                            <input type="date" class="form-control"
                                                                   name="warranties[expiry][]">
                                                        </div>

                                                        <!-- Input tambahan untuk Meter Reading & Production Time -->
                                                        <div id="meterReadingGroup" style="display: none;">
                                                            <div class="form-group">
                                                                <label>Meter Readings Unit</label>
                                                                <select class="form-control"
                                                                        name="warranties[meter_unit][]">
                                                                    <option value="h">Hours (h)</option>
                                                                    <option value="m">Minutes (m)</option>
                                                                    <option value="km">Kilometers (km)</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Meter Reading Value Limit</label>
                                                                <input type="number" class="form-control"
                                                                       name="warranties[meter_limit][]" min="0">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Certificate Number</label>
                                                            <input type="text" class="form-control"
                                                                   name="warranties[certificate][]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea class="form-control"
                                                                      name="warranties[description][]"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="btn btn-outline-success">Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body ">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="text-lg fw-semibold mb-0">Warranties</h6>
                                                        <!-- Tombol untuk membuka modal -->
                                                        <button type="button" id="openModalButton"
                                                                class="btn btn-outline-success">
                                                            Add Warranty
                                                        </button>

                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered basic-table table-warranties">
                                                        <thead>
                                                        <tr>
                                                            <th>Warranty Type</th>
                                                            <th hidden="true">Provider ID</th>
                                                            <th>Provider</th>
                                                            <th>Usage Term</th>
                                                            <th>Meter Limit</th>
                                                            <th>Expiry Date</th>
                                                            <th>Certificate</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <!-- Data akan ditambahkan di sini -->
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="bussiness" role="tabpanel"
                                     aria-labelledby="bussiness-tab">

                                    <div class="modal fade" id="addBusinessModal" tabindex="-1"
                                         aria-labelledby="addBusinessModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addBusinessModalLabel">Add Business</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="businessForm">
                                                        <div id="businessContainer">
                                                            <div class="business-group">
                                                                <div class="form-group">
                                                                    <label>Business Type</label>
                                                                    <select class="form-control business-type"
                                                                            name="business[0][type]" required>
                                                                        <option value="">Pilih Business Type</option>
                                                                        <option value="supplier">Supplier</option>
                                                                        <option value="manufacturer">Manufacturer
                                                                        </option>
                                                                        <option value="service_provider">Service
                                                                            Provider
                                                                        </option>
                                                                        <option value="owner">Owner</option>
                                                                        <option value="customer">Customer</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Business Name</label>
                                                                    <select class="form-control business-name"
                                                                            name="business[0][name]" required>
                                                                        <option value="">Loading...</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Business Asset Number</label>
                                                                    <input type="text"
                                                                           class="form-control business-asset-number"
                                                                           name="business[0][asset_number]" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Catalog</label>
                                                                    <input type="text"
                                                                           class="form-control business-catalog"
                                                                           name="business[0][catalog]" required>
                                                                </div>
                                                                <button type="button"
                                                                        class="btn btn-outline-danger btn-sm remove-business">
                                                                    Remove
                                                                </button>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-outline-success"
                                                                id="addMoreBusiness">+
                                                            Add More
                                                        </button>
                                                        <button type="submit" id="saveBusinessBtn"
                                                                class="btn btn-outline-success">Save Business
                                                        </button>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body ">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="text-lg fw-semibold mb-0">Bussiness </h6>
                                                        <button
                                                            class="submitBusiness btn btn-outline-success">
                                                            Add
                                                            Bussiness
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table basic-table mb-0 tableBusiness">
                                                        <thead>
                                                        <tr>
                                                            <th>Business Type</th>
                                                            <th>Business Name</th>
                                                            <th>Business Asset Number</th>
                                                            <th>Catalog</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="text-center tablevalueBusiness">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="tab-pane fade" id="personnel" role="tabpanel"
                                     aria-labelledby="personnel-tab">
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
                                            <table class="table basic-table mb-0" id="personnelTable">
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
                                </div>

                                <!-- Modal for Adding Personnel -->
                                <div class="modal fade" id="addPersonnelModal" tabindex="-1"
                                     aria-labelledby="addPersonnelModalLabel" aria-hidden="true">
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
                                                <button type="button" id="savePersonnelBtn"
                                                        class="btn btn-outline-success">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Adding Group -->
                                <div class="modal fade" id="addGroupModal" tabindex="-1"
                                     aria-labelledby="addGroupModalLabel"
                                     aria-hidden="true">
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
                                                <button type="button" id="saveGroupBtn" class="btn btn-outline-success">
                                                    Save Group
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                                    <!-- Files content goes here -->


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
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success"
                                                            onclick="saveData()">Save
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
                                        <table class="table basic-table mb-0">
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

                            </div>


                            <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                <!-- Log content goes here -->
                                <div class="row">
                                    <div class="col-md-12 border-1 radius-4 ">
                                        <div class="card-header">
                                            <div class="mb-4">
                                                <h6>
                                                    Schedule Maintenance
                                                </h6>
                                                <button class="btn btn-outline-success">Add
                                                    Log
                                                </button>
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
                                    <div class="col-md-12 border-1 radius-4 ">
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
                                    <div class="col-md-12 border-1 radius-4 ">
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
                                    <div class="col-md-12 border-1 radius-4 ">
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
                                    <div class="col-md-12 border-1 radius-4 ">
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
                                                            <button
                                                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mr-2">
                                                                View
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 border-1 radius-4 ">
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
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Asset Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                <input type="text" class="form-control" readonly value="{{$totalReceived ?? ''}}">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                <input type="text" class="form-control" readonly value="{{$totalAllReceipt ?? ''}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

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
                    <button type="button" class="btn btn-outline-success">Save changes</button>
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
                    <button type="button" class="btn btn-outline-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

</script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
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
                    // console.log(response)
                    swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Part saved successfully!',
                    })

                    window.location.href = "{{ route('part.list') }}";
                },
                error: function () {
                    console.log("Error")

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
                url: '{{ route("categories.get") }}',
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
                    <button class="btn btn-sm btn-outline-success selectCategoryBtn" data-id="${category.id}" data-name="${category.category_name}">Pilih</button>
                    <button class="btn btn-sm btn-outline-danger deleteCategoryBtn" data-id="${category.id}">Delete</button>
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
                        <td><button type="button" class="btn btn-outline-danger removeRow">Remove</button></td>
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
                        <td><button type="button" class="btn btn-outline-danger removeRow">Remove</button></td>
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
            let noteBlob = new Blob([noteContent], {type: "text/plain"});
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
            <button class="btn btn-outline-danger" onclick="deleteRow(this)">Delete</button>
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
        let usageTerm = document.getElementById("usageTerm");
        let expiryDateGroup = document.getElementById("expiryDateGroup");
        let meterReadingGroup = document.getElementById("meterReadingGroup");

        // Fetch data provider dari backend
        fetch('/business/getData') // Sesuaikan URL sesuai route CI4
            .then(response => response.json())
            .then(data => {
                let providerSelect = document.getElementById("providerSelect");
                providerSelect.innerHTML = '<option value="">Pilih Business</option>';

                data.forEach(provider => {
                    let option = document.createElement("option");
                    option.value = provider.id;
                    option.textContent = provider.business_name;
                    providerSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching providers:", error));

        // Event listener untuk Warranty Usage Term Type
        usageTerm.addEventListener("change", function () {
            let selectedValue = usageTerm.value;
            expiryDateGroup.style.display = "none";
            meterReadingGroup.style.display = "none";

            if (selectedValue === "date") {
                expiryDateGroup.style.display = "block";
            } else if (selectedValue === "meter_reading" || selectedValue === "production_time") {
                meterReadingGroup.style.display = "block";
                expiryDateGroup.style.display = "block";
            }
        });

        document.getElementById("warrantyForm").addEventListener("submit", function (e) {
            e.preventDefault(); // Mencegah submit form bawaan

            let table = document.querySelector(".table-warranties tbody");
            let rowCount = table.rows.length; // Hitung jumlah baris untuk index
            let index = rowCount; // Buat index untuk setiap input baru

            // Ambil nilai dari form
            let form = document.getElementById("warrantyForm");

            let type = form.querySelector("select[name='warranties[type][]']").value;
            let providerSelect = form.querySelector("select[name='warranties[provider][]']");
            let providerValue = providerSelect.value;
            let providerText = providerSelect.options[providerSelect.selectedIndex].text;

            let usageTerm = form.querySelector("select[name='warranties[usage_term][]']").value;
            let meterLimit = form.querySelector("input[name='warranties[meter_limit][]']").value || "-";
            let expiry = form.querySelector("input[name='warranties[expiry][]']").value || "-";
            let certificate = form.querySelector("input[name='warranties[certificate][]']").value;
            let description = form.querySelector("textarea[name='warranties[description][]']").value;

            // Validasi: Tidak boleh ada input kosong
            if (!type || !providerValue || !usageTerm || (!meterLimit && usageTerm !== "date") || !expiry || !certificate || !description) {
                alert("Harap isi semua kolom sebelum menyimpan!");
                return;
            }

            // Tambahkan baris baru ke tabel dengan index
            let newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td><input type="hidden" name="warranties[type][${index}]" value="${type}">${type}</td>
                <td><input type="hidden" name="warranties[provider][${index}]" value="${providerValue}">${providerText}</td>
                <td><input type="hidden" name="warranties[usage_term][${index}]" value="${usageTerm}">${usageTerm}</td>
                <td><input type="hidden" name="warranties[meter_limit][${index}]" value="${meterLimit}">${meterLimit}</td>
                <td><input type="hidden" name="warranties[expiry][${index}]" value="${expiry}">${expiry}</td>
                <td><input type="hidden" name="warranties[certificate][${index}]" value="${certificate}">${certificate}</td>
                <td><input type="hidden" name="warranties[description][${index}]" value="${description}">${description}</td>
                <td>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                </td>
            `;

            table.appendChild(newRow);

            // Reset form setelah submit
            form.reset();
            expiryDateGroup.style.display = "none";
            meterReadingGroup.style.display = "none";

            // Tutup modal
            $("#addWarrantyModal").modal("hide");
        });
    });


    // Fungsi untuk menghapus baris dari tabel
    function deleteRow(button) {
        let row = button.closest("tr");
        row.remove();
    }
</script>


<script>
    $(document).ready(function () {
        $("#openModalButton").click(function () {
            $("#addWarrantyModal").modal("show");
        });
    });
</script>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        let businessIndex = 0;

        function fetchBusinessNames(selectElement) {
            fetch('/business/getData')
                .then(response => response.json())
                .then(data => {
                    selectElement.innerHTML = '<option value="">Pilih Business</option>';
                    data.forEach(item => {
                        let option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.business_name;
                        selectElement.appendChild(option);
                    });
                })
                .catch(error => console.error("Error fetching business names:", error));
        }

        document.getElementById("addMoreBusiness").addEventListener("click", function () {
            let businessContainer = document.getElementById("businessContainer");
            let newBusinessGroup = document.createElement("div");
            newBusinessGroup.classList.add("business-group");

            newBusinessGroup.innerHTML = `
            <div class="form-group">
                <label>Business Type</label>
                <select class="form-control business-type" name="business[${businessIndex}][type]" required>
                    <option value="">Pilih Business Type</option>
                    <option value="supplier">Supplier</option>
                    <option value="manufacturer">Manufacturer</option>
                    <option value="service_provider">Service Provider</option>
                    <option value="owner">Owner</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            <div class="form-group">
                <label>Business Name</label>
                <select class="form-control business-name" name="business[${businessIndex}][name]" required>
                    <option value="">Loading...</option>
                </select>
            </div>
            <div class="form-group">
                <label>Business Asset Number</label>
                <input type="text" class="form-control business-asset-number" name="business[${businessIndex}][asset_number]" required>
            </div>
            <div class="form-group">
                <label>Catalog</label>
                <input type="text" class="form-control business-catalog" name="business[${businessIndex}][catalog]" required>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm remove-business">Remove</button>
            <hr>
        `;

            businessContainer.appendChild(newBusinessGroup);

            let newBusinessSelect = newBusinessGroup.querySelector(".business-name");
            fetchBusinessNames(newBusinessSelect);

            businessIndex++; // Increment index setiap kali menambahkan form baru
        });

        document.getElementById("businessContainer").addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-business")) {
                event.target.closest(".business-group").remove();
                updateFormIndexes(); // Update index setelah menghapus elemen

            }
        });

        function updateFormIndexes() {
            let businessGroups = document.querySelectorAll(".business-group");
            businessGroups.forEach((group, index) => {
                group.querySelector(".business-type").setAttribute("name", `business[${index}][type]`);
                group.querySelector(".business-name").setAttribute("name", `business[${index}][name]`);
                group.querySelector(".business-asset-number").setAttribute("name", `business[${index}][asset_number]`);
                group.querySelector(".business-catalog").setAttribute("name", `business[${index}][catalog]`);
            });
        }


        document.querySelector(".submitBusiness").addEventListener("click", function () {
            $('#addBusinessModal').modal('show');
            let initialSelect = document.querySelector(".business-name");
            fetchBusinessNames(initialSelect);
        });

        document.querySelector("#businessForm").addEventListener("submit", function (event) {
            event.preventDefault();

            let businessTableBody = document.querySelector(".tableBusiness tbody");
            let businessGroups = document.querySelectorAll(".business-group");

            businessGroups.forEach((group, index) => {
                let businessTypeElement = group.querySelector(".business-type");
                let businessNameElement = group.querySelector(".business-name");
                let businessAssetNumberElement = group.querySelector(".business-asset-number");
                let businessCatalogElement = group.querySelector(".business-catalog");

                let businessType = businessTypeElement.value;
                let businessName = businessNameElement.value;
                let businessAssetNumber = businessAssetNumberElement.value;
                let businessCatalog = businessCatalogElement.value;

                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                <td value="${businessType}" name="business[${index}][type]">${businessType}</td>
                <td value="${businessName}" name="business[${index}][name]">${businessName}</td>
                <td value="${businessAssetNumber}" name="business[${index}][asset_number]">${businessAssetNumber}</td>
                <td value="${businessCatalog}" name="business[${index}][catalog]">${businessCatalog}</td>
                <td><button type="button" class="btn btn-outline-danger btn-sm remove-row">Delete</button></td>
            `;

                businessTableBody.appendChild(newRow);
            });

            $('#addBusinessModal').modal('hide');
            document.getElementById("businessForm").reset();
        });

        function getTableData() {
            let tableRows = document.querySelectorAll(".tableBusiness tbody tr"); // Ambil semua baris dalam tbody
            let data = [];

            tableRows.forEach((row) => {
                let rowData = {
                    businessType: row.cells[0].textContent.trim(),
                    businessName: row.cells[1].textContent.trim(),
                    businessAssetNumber: row.cells[2].textContent.trim(),
                    businessCatalog: row.cells[3].textContent.trim(),
                };

                data.push(rowData);
            });

            console.log(data);
            return data;
        }

        function updateFormIndexes() {
            let businessGroups = document.querySelectorAll(".business-group");
            businessGroups.forEach((group, index) => {
                group.querySelector(".business-type").setAttribute("name", `business[${index}][type]`);
                group.querySelector(".business-name").setAttribute("name", `business[${index}][name]`);
                group.querySelector(".business-asset-number").setAttribute("name", `business[${index}][asset_number]`);
                group.querySelector(".business-catalog").setAttribute("name", `business[${index}][catalog]`);
            });
        }

        document.getElementById("saveBusinessBtn").addEventListener("click", function () {
            let businessGroups = document.querySelectorAll(".business-group");
            let tableBody = document.querySelector(".tableBusiness tbody");

            businessGroups.forEach((group, index) => {
                let type = group.querySelector(".business-type").value;
                let name = group.querySelector(".business-name").value;
                let assetNumber = group.querySelector(".business-asset-number").value;
                let catalog = group.querySelector(".business-catalog").value;

                let newRow = document.createElement("tr");

                newRow.innerHTML = `
                <td>${type} <input type="hidden" name="business[${index}][type]" value="${type}"></td>
                <td>${name} <input type="hidden" name="business[${index}][name]" value="${name}"></td>
                <td>${assetNumber} <input type="hidden" name="business[${index}][asset_number]" value="${assetNumber}"></td>
                <td>${catalog} <input type="hidden" name="business[${index}][catalog]" value="${catalog}"></td>
                <td><button type="button" class="btn btn-outline-danger btn-sm remove-row">Remove</button></td>
            `;

                tableBody.appendChild(newRow);
            });

            // Kosongkan form setelah data ditambahkan ke tabel
            document.getElementById("businessContainer").innerHTML = "";
            businessIndex = 0;
        });

        document.querySelector(".tableBusiness tbody").addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-row")) {
                event.target.closest("tr").remove();
                updateTableIndexes(); // Update index setelah menghapus row di tabel
            }
        });

        function updateFormIndexes() {
            let businessGroups = document.querySelectorAll(".business-group");
            businessGroups.forEach((group, index) => {
                group.querySelector(".business-type").setAttribute("name", `business[${index}][type]`);
                group.querySelector(".business-name").setAttribute("name", `business[${index}][name]`);
                group.querySelector(".business-asset-number").setAttribute("name", `business[${index}][asset_number]`);
                group.querySelector(".business-catalog").setAttribute("name", `business[${index}][catalog]`);
            });
            console.log("Updated form indexes");
        }
    });


</script>
<script>
    let bomData = [];

    function addBOMRow() {
        // Dapatkan select element untuk part
        let partSelect = document.getElementById("partName");
        let partId = partSelect.value.trim();
        // Ambil text dari option yang dipilih
        let partName = partSelect.options[partSelect.selectedIndex].text;
        let quantity = document.getElementById("quantity").value;
        let bomControl = document.getElementById("bomControl").value.trim();

        if (partId === "" || quantity === "") {
            alert("All fields are required!");
            return;
        }

        // Simpan data BOM; jika perlu simpan juga partId
        let newRow = {
            partId: partId,
            quantity: quantity,
            bomControl: bomControl,
            asset: partName
        };

        bomData.push(newRow);
        updateTable();

        // Reset form
        document.getElementById("bomForm").reset();

        // Close modal
        let modal = document.getElementById('addBOMModal');
        let modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();

        // Bersihkan modal-backdrop jika tertinggal
        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        }, 500);
    }

    function updateTable() {
        let tableBody = document.getElementById("bomTableBody");
        tableBody.innerHTML = "";

        bomData.forEach((item, index) => {
            let row = `
                <tr>
                    <td>
                        <input class="form-control" type="text" value="${item.quantity}"
                               name="bomData[${index}][quantity]"
                               onchange="updateBOM(${index}, 'quantity', this.value)">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="${item.bomControl}"
                               name="bomData[${index}][bomControl]"
                               onchange="updateBOM(${index}, 'bomControl', this.value)">
                    </td>
                    <td>
                        <input class="form-control" type="text" value="${item.asset}"
                               name="bomData[${index}][asset]"
                               onchange="updateBOM(${index}, 'asset', this.value)">
                    </td>
                    <td>
                        <button class="btn btn-outline-danger" onclick="removeBOMRow(${index})">Remove</button>
                    </td>
                </tr>
            `;
            tableBody.innerHTML += row;
        });

        document.getElementById("bomDataInput").value = JSON.stringify(bomData);
    }

    function updateBOM(index, field, value) {
        bomData[index][field] = value;
        document.getElementById("bomDataInput").value = JSON.stringify(bomData);
    }

    function removeBOMRow(index) {
        bomData.splice(index, 1);
        updateTable();
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addStockBtn").addEventListener("click", function () {
            let tableBody = document.getElementById("stockTableBody");
            let index = tableBody.rows.length;

            let status = document.getElementById("status").value;
            let facility = document.getElementById("facility").value;
            let aisle = document.getElementById("aisle").value;
            let row = document.getElementById("row").value;
            let bin = document.getElementById("bin").value;
            let qtyOnHand = document.getElementById("qtyOnHand").value;
            let minQty = document.getElementById("minQty").value;
            let maxQty = document.getElementById("maxQty").value;

            if (!facility || !aisle || !row || !bin) {
                alert("Facility, Aisle, Row, dan Bin harus diisi!");
                return;
            }

            let duplicate = false;
            document.querySelectorAll("#stockTableBody tr").forEach(row => {
                let existingFacility = row.cells[1].innerText;
                let existingAisle = row.cells[2].innerText;
                let existingRow = row.cells[3].innerText;
                let existingBin = row.cells[4].innerText;

                if (existingFacility === facility && existingAisle === aisle && existingRow === row && existingBin === bin) {
                    duplicate = true;
                }
            });

            if (duplicate) {
                alert("Data dengan Facility, Aisle, Row, dan Bin yang sama sudah ada!");
                return;
            }

            let newRow = `<tr>
                <td>${status} <input type="hidden" name="data[${index}][status]" value="${status}"></td>
                <td>${facility} <input type="hidden" name="data[${index}][facility]" value="${facility}"></td>
                <td>${aisle} <input type="hidden" name="data[${index}][aisle]" value="${aisle}"></td>
                <td>${row} <input type="hidden" name="data[${index}][row]" value="${row}"></td>
                <td>${bin} <input type="hidden" name="data[${index}][bin]" value="${bin}"></td>
                <td>${qtyOnHand} <input type="hidden" name="data[${index}][qtyOnHand]" value="${qtyOnHand}" id="qty-${index}"></td>
                <td>${minQty} <input type="hidden" name="data[${index}][minQty]" value="${minQty}"></td>
                <td>${maxQty} <input type="hidden" name="data[${index}][maxQty]" value="${maxQty}"></td>
                <td><button type="button" class="btn btn-warning btn-sm adjustBtn" data-index="${index}">Add Adjust</button></td>
            </tr>`;

            tableBody.innerHTML += newRow;

            document.getElementById("aisle").value = "";
            document.getElementById("row").value = "";
            document.getElementById("bin").value = "";
            document.getElementById("qtyOnHand").value = "";
            document.getElementById("minQty").value = "";
            document.getElementById("maxQty").value = "";

            var modal = bootstrap.Modal.getInstance(document.getElementById("addStockModal"));
            modal.hide();
        });

        // Event listener untuk tombol "Add Adjust"
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("adjustBtn")) {
                let index = event.target.getAttribute("data-index");
                let qtyOnHand = document.getElementById(`qty-${index}`).value;

                document.getElementById("editRowIndex").value = index;
                document.getElementById("editQtyOnHand").value = qtyOnHand;

                let modal = new bootstrap.Modal(document.getElementById("adjustStockModal"));
                modal.show();
            }
        });

        // Simpan perubahan dari modal
        document.getElementById("saveAdjustment").addEventListener("click", function () {
            let index = document.getElementById("editRowIndex").value;
            let newQty = document.getElementById("editQtyOnHand").value;

            if (newQty === "") {
                alert("Qty On Hand tidak boleh kosong!");
                return;
            }

            // Update tabel utama
            let qtyCell = document.querySelector(`#stockTableBody tr:nth-child(${parseInt(index) + 1}) td:nth-child(6)`);
            qtyCell.innerHTML = `${newQty} <input type="hidden" name="data[${index}][qtyOnHand]" value="${newQty}" id="qty-${index}">`;

            // Tutup modal
            var modal = bootstrap.Modal.getInstance(document.getElementById("adjustStockModal"));
            modal.hide();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let stockLogs = {}; // Menyimpan log berdasarkan index item

        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("adjustBtn")) {
                let index = event.target.getAttribute("data-index");

                let row = document.querySelector(`#stockTableBody tr:nth-child(${parseInt(index) + 1})`);
                let location = row.cells[1].textContent;
                let aisle = row.cells[2].textContent;
                let rowData = row.cells[3].textContent;
                let bin = row.cells[4].textContent;
                let qtyOnHand = row.cells[5].textContent.trim().split(" ")[0];

                document.getElementById("editRowIndex").value = index;
                document.getElementById("editLocation").textContent = location;
                document.getElementById("editAisle").textContent = aisle;
                document.getElementById("editRow").textContent = rowData;
                document.getElementById("editBin").textContent = bin;
                document.getElementById("editQtyOnHand").value = qtyOnHand;

                if (!stockLogs[index]) {
                    stockLogs[index] = {date: [], user: [], description: [], oldQty: [], newQty: []};

                    let now = new Date().toLocaleString();
                    let user = "Admin";
                    let description = `Initial stock added: ${qtyOnHand}`;

                    stockLogs[index].date.push(now);
                    stockLogs[index].user.push(user);
                    stockLogs[index].description.push(description);
                    stockLogs[index].oldQty.push("0");
                    stockLogs[index].newQty.push(qtyOnHand);
                }

                renderLogTable(index);

                let modal = new bootstrap.Modal(document.getElementById("adjustStockModal"));
                modal.show();
            }
        });

        document.getElementById("saveAdjustment").addEventListener("click", function () {
            let index = document.getElementById("editRowIndex").value;
            let oldQty = document.getElementById(`qty-${index}`).value;
            let newQty = document.getElementById("editQtyOnHand").value;

            if (newQty === "" || newQty < 0) {
                alert("Qty On Hand tidak boleh kosong atau negatif!");
                return;
            }

            let qtyCell = document.querySelector(`#stockTableBody tr:nth-child(${parseInt(index) + 1}) td:nth-child(6)`);
            qtyCell.innerHTML = `${newQty} <input type="hidden" name="data[${index}][qtyOnHand]" value="${newQty}" id="qty-${index}">`;

            let now = new Date().toLocaleString();
            let user = "Admin";
            let description = `Stock adjusted from ${oldQty} to ${newQty}`;

            stockLogs[index].date.push(now);
            stockLogs[index].user.push(user);
            stockLogs[index].description.push(description);
            stockLogs[index].oldQty.push(oldQty);
            stockLogs[index].newQty.push(newQty);

            renderLogTable(index);

            let modal = bootstrap.Modal.getInstance(document.getElementById("adjustStockModal"));
            $('.modal-backdrop').remove();
            modal.hide();
        });

        function renderLogTable(index) {
            let logTableBody = document.getElementById("logTableBody");
            logTableBody.innerHTML = stockLogs[index].date.map((_, i) => `
            <tr>
                <td>${stockLogs[index].date[i]}<input type="hidden" name="log[${index}][date][${i}]" value="${stockLogs[index].date[i]}"></td>
                <td>${stockLogs[index].user[i]}<input type="hidden" name="log[${index}][user][${i}]" value="${stockLogs[index].user[i]}"></td>
                <td>${stockLogs[index].description[i]}<input type="hidden" name="log[${index}][description][${i}]" value="${stockLogs[index].description[i]}"></td>
                <td>${stockLogs[index].oldQty[i]}<input type="hidden" name="log[${index}][oldQty][${i}]" value="${stockLogs[index].oldQty[i]}"></td>
                <td>${stockLogs[index].newQty[i]}<input type="hidden" name="log[${index}][newQty][${i}]" value="${stockLogs[index].newQty[i]}"></td>
            </tr>
        `).join("");
        }
    });


</script>
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
                    <button class="btn btn-outline-primary btn-sm" onclick="selectAccount('${item.name}', '${item.description}')">Pilih</button>
                    <button class="btn btn-outline-danger btn-sm" onclick="deleteAccount(${item.id})">Hapus</button>
                </td>
                </tr>`;
                    table.innerHTML += row;
                });
            })
            .catch(error => console.error("Error fetching accounts:", error));
    }

    // Fungsi memilih account
    function selectAccount(account, description) {
        const dropdown = document.getElementById("accountInput");

        // Cek apakah account sudah ada di dropdown
        let optionExists = false;
        for (let i = 0; i < dropdown.options.length; i++) {
            if (dropdown.options[i].value === account) {
                optionExists = true;
                dropdown.selectedIndex = i; // Pilih opsi yang sudah ada
                break;
            }
        }

        // Jika belum ada, tambahkan ke dropdown
        if (!optionExists) {
            let option = new Option(`${account} - ${description}`, account);
            dropdown.add(option);
            dropdown.value = account;
        }
        $('.modal-backdrop').remove();
        $("#accountModal").modal("hide");
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
            body: JSON.stringify({account: newAccount, description: newDescription})
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
        loadChargeDepartments(); // Load data saat halaman dimuat

        document.getElementById("chargeForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Mencegah reload halaman
            addChargeDepartment(); // Menjalankan fungsi tambah data
        });
    });

    // Fungsi menampilkan data ke tabel dengan AJAX
    function loadChargeDepartments() {
        fetch("{{ route('account.charge_list') }}") // Ganti dengan URL API Anda
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById("chargeTableBody");
                tableBody.innerHTML = ""; // Kosongkan tabel sebelum menambahkan data

                data.forEach(item => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.description ? item.description : "-"}</td>
                    <td>${item.facility ? item.facility.name : "-"}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success" onclick="selectCharge('${item.code}', '${item.description}')">Pilih</button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteCharge('${item.code}')">Delete</button>
                    </td>
                `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error("Error fetching charge departments:", error));
    }


    // Fungsi menambah charge department baru
    function addChargeDepartment() {
        const chargeCode = document.getElementById("chargeCode").value.trim();
        const chargeDescription = document.getElementById("chargeDescription").value.trim();
        const chargeFacility = document.getElementById("chargeFacility").value;

        alert(chargeFacility)
        if (chargeCode === "" || chargeDescription === "") {
            alert("Semua field harus diisi!");
            return;
        }

        fetch("{{ route('account.charge_store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({code: chargeCode, description: chargeDescription, facility: chargeFacility})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadChargeDepartments(); // Refresh tabel
                    document.getElementById("chargeForm").reset(); // Reset form
                    $("#ChargeModal").modal("hide"); // Tutup modal setelah sukses
                } else {
                    alert("Gagal menambahkan data!");
                }
            })
            .catch(error => console.error("Error adding charge department:", error));
    }

    // Fungsi edit charge department
    function editCharge(code, description, facility) {
        document.getElementById("chargeCode").value = code;
        document.getElementById("chargeDescription").value = description;
        document.getElementById("chargeFacility").value = facility;

        $("#ChargeModal").modal("show"); // Buka modal untuk edit

        // Ganti tombol Save menjadi Update
        const saveButton = document.querySelector("#ChargeModal .btn-outline-primary");
        saveButton.textContent = "Update";
        saveButton.onclick = function () {
            updateChargeDepartment(code);
        };
    }

    function selectCharge(code, description) {
        const selectElement = document.getElementById("chargemanagement");

        // Kosongkan opsi sebelumnya, kecuali default "-- Select Charge Department --"
        selectElement.innerHTML = '<option value="">-- Select Charge Department --</option>';

        // Tambahkan opsi yang dipilih
        const option = document.createElement("option");
        option.value = code;
        option.textContent = `${description}`;
        option.selected = true; // Pilih otomatis

        selectElement.appendChild(option);

        // Tutup modal setelah memilih
        $("#ChargeModal").modal("hide");
    }


    // Fungsi update charge department
    {{--function updateChargeDepartment(originalCode) {--}}
    {{--    const chargeCode = document.getElementById("chargeCode").value.trim();--}}
    {{--    const chargeDescription = document.getElementById("chargeDescription").value.trim();--}}
    {{--    const chargeFacility = document.getElementById("chargeFacility").value;--}}

    {{--    if (chargeCode === "" || chargeDescription === "" || chargeFacility === "") {--}}
    {{--        alert("Semua field harus diisi!");--}}
    {{--        return;--}}
    {{--    }--}}

    {{--    fetch("{{ route('account.charge_update', ':code') }}".replace(":code", originalCode), {--}}
    {{--        method: "PUT",--}}
    {{--        headers: {--}}
    {{--            "Content-Type": "application/json",--}}
    {{--            "X-CSRF-TOKEN": "{{ csrf_token() }}"--}}
    {{--        },--}}
    {{--        body: JSON.stringify({ code: chargeCode, description: chargeDescription, facility: chargeFacility })--}}
    {{--    })--}}
    {{--        .then(response => response.json())--}}
    {{--        .then(data => {--}}
    {{--            if (data.success) {--}}
    {{--                loadChargeDepartments(); // Refresh tabel--}}
    {{--                document.getElementById("chargeForm").reset(); // Reset form--}}
    {{--                $("#ChargeModal").modal("hide"); // Tutup modal--}}

    {{--                // Ganti tombol kembali ke Save--}}
    {{--                const saveButton = document.querySelector("#ChargeModal .btn-outline-primary");--}}
    {{--                saveButton.textContent = "Save";--}}
    {{--                saveButton.onclick = addChargeDepartment;--}}
    {{--            } else {--}}
    {{--                alert("Gagal memperbarui data!");--}}
    {{--            }--}}
    {{--        })--}}
    {{--        .catch(error => console.error("Error updating charge department:", error));--}}
    {{--}--}}

    // Fungsi menghapus charge department
    function deleteCharge(code) {
        if (!confirm("Yakin ingin menghapus charge department ini?")) return;

        fetch("{{ route('account.charge_delete', ':code') }}".replace(":code", code), {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({code: code})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadChargeDepartments(); // Refresh tabel setelah delete
                } else {
                    alert("Gagal menghapus data!");
                }
            })
            .catch(error => console.error("Error deleting charge department:", error));
    }
</script>
