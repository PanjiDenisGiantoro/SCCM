@extends('layout.layout2')

@php
    if(!empty($purchase)){
        $title = 'Edit Purchase Request';
        $subTitle = 'Edit Purchase Request';
    }else{
        $title = 'New Purchase Request';
        $subTitle = 'New Purchase Request';
    }

@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <style>
        span {
            display: inline;
        }
    </style>
    @if(!empty($purchase))
        <form id="purchaseRequestForm" action="{{ route('purchase.update', $purchase->id) }}" method="POST"
              enctype="multipart/form-data">
            @method('PUT')
            @else
                <form id="purchaseRequestForm" action="{{ route('purchase.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">New Purchase Request</h4>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">PR Number</label>
                                            <input type="text"
                                                   class="form-control @error('pr_number') is-invalid @enderror"
                                                   name="pr_number" readonly
                                                   @if(!empty($purchase)) value="{{ $purchase->no_pr }}" @else
                                                       value="{{ $code }}"
                                                @endif
                                            >
                                            @error('pr_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Request Date</label>
                                            <input type="date"
                                                   class="form-control @error('request_date') is-invalid @enderror"
                                                   name="request_date" required
                                                   @if(!empty($purchase)) value="{{ $purchase->request_date }}" @else
                                                       value="{{ old('request_date') }}" @endif>
                                            @error('request_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Required Date</label>
                                            <input type="date"
                                                   class="form-control @error('required_date') is-invalid @enderror"
                                                   name="required_date" required
                                                   @if(!empty($purchase)) value="{{ $purchase->required_date }}" @else
                                                       value="{{ old('required_date') }}" @endif>
                                            @error('required_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Notes</label>
                                            <textarea class="form-control" name="notes">@if(!empty($purchase))
                                                    {{ $purchase->description }}
                                                @else
                                                    {{ old('notes') }}
                                                @endif</textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Upload Supporting Documents</label>
                                            <input type="file"
                                                   class="form-control @error('supporting_documents') is-invalid @enderror"
                                                   name="supporting_documents"
                                                   value="{{ old('supporting_documents') }}">

                                            <div class="text-center mt-3">
                                                @if(!empty($purchase))
                                                    <a href="{{ asset('storage/' . $purchase->doc) }}"
                                                       target="_blank">
                                                        <iconify-icon icon="lucide:download"
                                                                      class="text-xl btn btn-outline-info"></iconify-icon>
                                                        Download
                                                    </a>
                                                @endif
                                            </div>

                                            @error('supporting_documents')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Business</label>
                                            <select class="form-select select2" name="business">
                                                <option value="">-- Pilih Business --</option>
                                                @foreach($business as $busines)
                                                    <option value="{{ $busines->id }}"
                                                            @if(!empty($purchase) && $purchase->business_id == $busines->id) selected @endif
                                                    >@if(!empty($purchase) && $purchase->business_id == $busines->id)
                                                            {{ $busines->business_name }}
                                                        @else
                                                            {{ $busines->business_name }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h4 class="card-title">Additional Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Account</label>
                                            <select class="form-select select2" name="account">
                                                <option value="">-- Pilih Account --</option>
                                                @foreach($account as $accounts)
                                                    <option
                                                        @if(!empty($purchase) && !empty($purchase->purchaseAdditional) &&$purchase->purchaseAdditional->account_id == $accounts->id) selected
                                                        value="{{ $accounts->id }}"
                                                        @else
                                                        value="{{ $accounts->id }}"@endif>
                                                        @if(!empty($purchase) && !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->account_id == $accounts->id)
                                                            {{ $purchase->purchaseAdditional->accounts->name }}
                                                        @else
                                                            {{ $accounts->name }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Charge Department</label>
                                            <select class="form-select select2" name="chargemanagement">
                                                <option value="">-- Pilih Charge Department --</option>
                                                @foreach($charge as $chargemanagement)
                                                    <option

                                                        @if(!empty($purchase) && !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->charge_department == $chargemanagement->id) selected
                                                        @endif
                                                        value="{{ $chargemanagement->id }}">
                                                        @if(!empty($purchase) && !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->charge_management == $chargemanagement->id)
                                                            {{ $purchase->purchaseAdditional->charge_account->name }}
                                                        @else
                                                            {{ $chargemanagement->name }}
                                                        @endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Ship To Location</label>
                                            <select class="form-select select2" name="ship_to_location">
                                                <option value="">-- Pilih Facility --</option>
                                                @foreach($facilities as $facility)
                                                    <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                    @foreach($facility->children as $child)
                                                        <option
                                                            @if(!empty($purchase) && $purchase->asset_id == $child->id) selected @else
                                                            value="{{ $child->id }}"@endif>
                                                            @if(!empty($purchase) && $purchase->asset_id == $child->id)
                                                                ->   {{ $child->name }}
                                                            @else
                                                                ->  {{ $child->name }}
                                                            @endif
                                                            </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Associated / Impacted Work Order</label>
                                            <select class="form-select select2" name="work_order">
                                                <option value="">-- select Work Order --</option>
                                                @foreach($wo as $workorder)
                                                    <option
                                                        @if(!empty($purchase) && !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->wo_id == $workorder->id) selected
                                                        value="{{ $workorder->id }}"
                                                        @else
                                                        value="{{ $workorder->id }}"@endif>
                                                        @if(!empty($purchase) &&  !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->wo_id == $workorder->id)
                                                            {{ $purchase->purchaseAdditional->wos->code ?? '' }}
                                                        @else
                                                        {{ $workorder->code }}@endif</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Associated / Impacted Asset</label>
                                            <select class="form-control select2" name="impacted_asset">
                                                <option value="">-- select Asset --</option>
                                                @foreach ($groupedData as $group)
                                                    <optgroup label="{{ $group['text'] }}">
                                                        @foreach ($group['children'] as $child)
                                                            <option value="{{ $child['id'] }}"
                                                                    data-type="{{ $group['text'] }}">
                                                                {{ $child['text'] }} ({{ $group['text'] }})
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="production_impact"
                                               id="productionImpact" @if(!empty($purchase) && !empty($purchase->purchaseAdditional) && $purchase->purchaseAdditional->impacted_production == true) checked @endif>
                                        <label class="form-check-label" for="productionImpact">
                                            Production equipment is impacted
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Item List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="itemTable">
                                <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th hidden>model</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($purchase->purchaseAdditional))
                                @foreach ($purchase->purchaseBodies as $body)
                                    @php
                                        $item = null;
                                        if ($body->model == 'part') {
                                            $item = $body->part;
                                        } elseif ($body->model == 'equipment') {
                                            $item = $body->equipment;
                                        } elseif ($body->model == 'tool') {
                                            $item = $body->tools;
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <select class="form-control item_code select2" name="item_code[]" required onchange="updateItemName(this)">
                                                <option value="{{ $body->id }}" selected data-name="{{ $body->nameParts ?? $body->name }}" data-type="{{ $body->model }}">
                                                    {{ $body->id }} - {{ $item->nameParts ?? $item->name }} ({{ $body->model }})
                                                </option>
                                                <option value="custom">-- Not in Inventory --</option>
                                            </select>
                                            <input type="text" class="form-control custom_item_name" name="custom_item_name[]" placeholder="Enter item name" style="display:none; margin-top:5px;">
                                        </td>
                                        <td><input type="text" class="form-control item_name" name="item_name[]" readonly value="{{ $item->nameParts ?? $item->name ?? '' }}"></td>
                                        <td hidden><input type="text" class="form-control model" name="model[]" readonly value="{{ $body->model }}"></td>
                                        <td><input type="number" class="form-control quantity" name="quantity[]" required value="{{ $body->qty }}" oninput="calculateTotal(this)"></td>
                                        <td><input type="number" class="form-control unit_price" name="unit_price[]" required value="{{ $body->unit_price }}" oninput="calculateTotal(this)"></td>
                                        <td><input type="text" class="form-control total_price" name="total_price[]" readonly value="{{ number_format($body->total_price, 0, '.', '') }}"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">X</button></td>
                                    </tr>
                                @endforeach
                                    @endif
                                </tbody>

                            </table>
                            <button type="button" class="btn btn-outline-info" onclick="addItem()">+ Add Item</button>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" name="totalAmount" id="totalAmount" value="
                                    @if(!empty($purchase))
                                    {{ number_format($purchase->total, 0, '.', '') }}"
                                    @endif
                                           readonly>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-success mt-3">Submit Request</button>
                        </div>
                    </div>
                </form>
                @endsection

                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
                <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <!-- Tambahkan di bagian head -->
                <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
                <script>
                    let items = @json($data); // Data dari PHP

                    function addItem() {
                        let table = document.getElementById("itemTable").getElementsByTagName("tbody")[0];
                        let row = table.insertRow();

                        let options = `<option value="">-- Select Item --</option>`;
                        items.forEach(item => {

                            options += `<option value="${item.id}" data-name="${item.name}" data-type="${item.type}">${item.id} - ${item.name} (${item.type})</option>`;
                        });

                        // Tambahkan opsi item tidak terdaftar
                        options += `<option value="custom">-- Not in Inventory --</option>`;


                        row.innerHTML = `
            <td>
                <select class="form-control item_code select2" name="item_code[]" required onchange="updateItemName(this)">
                    ${options}
                </select>
                <input type="text" class="form-control custom_item_name" name="custom_item_name[]" placeholder="Enter item name" style="display:none; margin-top:5px;">
            </td>
            <td><input type="text" class="form-control item_name" name="item_name[]" readonly></td>
            <td hidden><input type="text" class="form-control model" name="model[]" readonly></td>
            <td><input type="number" class="form-control quantity" name="quantity[]" required oninput="calculateTotal(this)"></td>
            <td><input type="number" class="form-control unit_price" name="unit_price[]" required oninput="calculateTotal(this)"></td>
            <td><input type="text" class="form-control total_price" name="total_price[]" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">X</button></td>
        `;
                        $('.select2').select2(); // Inisialisasi Select2 untuk elemen yang baru ditambahkan

                    }

                    function updateItemName(select) {
                        let row = select.closest("tr");
                        let selectedOption = select.options[select.selectedIndex];
                        let itemNameField = row.querySelector(".item_name");
                        let customItemInput = row.querySelector(".custom_item_name");
                        let model = row.querySelector(".model");

                        if (select.value === "custom") {
                            customItemInput.style.display = "block";
                            itemNameField.value = "";
                            customItemInput.addEventListener("input", function () {
                                itemNameField.value = customItemInput.value;
                            });
                        } else {
                            customItemInput.style.display = "none";
                            itemNameField.value = selectedOption.getAttribute("data-name") || "";
                            model.value = selectedOption.getAttribute("data-type") || "";
                        }
                    }

                    function removeItem(button) {
                        let row = button.closest("tr");
                        row.remove();
                        updateGrandTotal();
                    }

                    function calculateTotal(input) {
                        let row = input.closest("tr");
                        let quantity = row.querySelector(".quantity").value;
                        let unitPrice = row.querySelector(".unit_price").value;
                        let totalPriceField = row.querySelector(".total_price");

                        totalPriceField.value = (quantity && unitPrice) ? (quantity * unitPrice).toFixed(0) : "";

                        updateGrandTotal();
                    }

                    function updateGrandTotal() {
                        let totalAmount = 0;
                        document.querySelectorAll(".total_price").forEach(input => {
                            let value = parseFloat(input.value);
                            if (!isNaN(value)) {
                                totalAmount += value;
                            }
                        });

                        document.getElementById("totalAmount").value = totalAmount.toFixed(0);
                    }
                </script>

                <script>

                    $(document).ready(function () {
                        $('.select2').select2({
                            width: '100%',
                            dropdownParent: $('body') // Pastikan dropdown tidak berada dalam elemen tersembunyi
                        });


                        $("#purchaseRequestForm").on("submit", function (event) {
                            event.preventDefault();
                            Swal.fire({
                                title: "Are you sure?",
                                text: "Do you want to submit this purchase request?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, submit it!",
                                cancelButtonText: "Cancel"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.submit();
                                }
                            });
                        });
                    });
                </script>
