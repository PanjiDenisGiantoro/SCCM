@extends('layout.layout2')

@php
    $title = 'Receipt';
    $subTitle = 'Create Receipt';
@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <style>
        span {
            display: inline;
        }
    </style>
    <form id="myForm" action="{{ route('receipt.store') }}" method="post">
        @csrf
    <div class="card small-card">
        <div class="card-header d-flex justify-content-end p-2">
            <button class="btn btn-dark btn-sm m-1">Back</button>
            <button type="button" class="btn btn-outline-info btn-sm m-1" onclick="confirmSave()">Save</button>
        </div>

        <div class="card-body p-2">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="card small-card">
                        <div class="card-body text-center bg-body-secondary p-2">
                            <p class="small-text">{{ $code }}</p>
                            <input type="text" hidden name="code" class="form-control form-control-sm" value="{{ $code }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card small-card">
                        <div class="card-body bg-warning text-center p-2">
                            <h6 class="small-text">Draft</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card small-card mt-2">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">No PO</label>
                        <select class="form-select form-select-sm select2" id="po_number" name="po_number"  data-placeholder="Pilih No PO">
                            <option></option>
                            @foreach($purchaseOrder as $list)
                                <option value="{{ $list->id }}">{{ $list->po_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">Supplier</label>
                        <select id="supplier" name="supplier_id" class="form-select form-select-sm" readonly">
                            <option selected>Loading...</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="date_ordered">Date Ordered</label>
                        <input type="date" class="form-control form-control-sm" name="date_ordered">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="date_received">Date Received</label>
                        <input type="date" class="form-control form-control-sm"name="date_received">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="packing_slip">Packing Slip</label>
                        <input type="text" class="form-control form-control-sm" name="packing_slip">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="surat_jalan">No. Surat Jalan</label>
                        <input type="text" class="form-control form-control-sm" name="surat_jalan">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card small-card mt-4">
        <div class="card-header p-2">
            <h6 class="small-text">Add Lines</h6>
        </div>
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">Add Part</label>
                        <select class="form-select form-select-sm" id="parts">
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">Qty Received</label>
                        <input type="number" class="form-control form-control-sm" id="qty">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">Unit Price</label>
                        <input type="number" class="form-control form-control-sm" id="unit_price">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small-text" for="supplier">Received To</label>
                       <input type="text" class="form-control form-control-sm" id="received_to">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-outline-info btn-sm m-1" id="add">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card small-card mt-2">
                <div class="card-header p-2">
                    <h6 class="small-text">List Lines</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-sm basic-table mb-0" >
                            <thead>
                            <tr>
                                <th>Asset</th>
                                <th>Qty Received</th>
                                <th>Unit Price</th>
                                <th>Received To</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="po_items">
                            {{-- Data Barang akan ditampilkan di sini --}}
                            </tbody>
                        </table>

                    </div>
                </div>
        </div>
        </div>
        <div class="col-md-3">
            <div class="card small-card mt-2">
                <div class="card-header p-2">
                    <h6 class="small-text">Summary</h6>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="small-text" for="supplier">Total Price</label>
                                <input type="text" class="form-control form-control-sm" name="total_price" id="total_price" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </form>
@endsection

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {

        $(".select2").select2({
            allowClear: true
        });

        function loadStockOptions(selectElement, selectedValue = '') {

            $.ajax({
                url: "{{ url('api/stock') }}",
                type: "GET",
                success: function (response) {
                    let stockOptions = '<option value="">Pilih Lokasi</option>';
                    response.stocks.forEach(function (stock) {
                        let selected = stock.id == selectedValue ? 'selected' : '';
                        stockOptions += `<option value="${stock.id}" ${selected}>${stock.location}</option>`;
                    });
                    selectElement.html(stockOptions);
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal mengambil data stok.",
                    });
                }
            });
        }

        let partDetails = {}; // untuk menyimpan detail part sementara

        function loadParts(poIds) {
            let $parts = $('#parts');

            // Kosongkan dan tampilkan indikator loading
            $parts.empty().append(new Option('Loading parts...', '', true, true)).prop('disabled', true).trigger('change');

            $.ajax({
                url: "{{ route('receipt.getpurchase') }}",
                type: "GET",
                data: { po_ids: poIds },
                success: function(response) {
                    $parts.empty(); // kosongkan lagi setelah sukses
                    partDetails = {}; // reset data
                    let $supplier = $('#supplier');
                    $supplier.empty(); // kosongkan isi sebelumnya

                    if (response.data.length > 0 && response.data[0].getpurchaseorder?.business) {
                        let supplierName = response.data[0].getpurchaseorder.business.business_name;
                        let supplierId = response.data[0].getpurchaseorder.business.id;

                        $supplier.append(new Option(supplierName, supplierId, true, true)).trigger('change');
                    }
                    // Tambahkan opsi default
                    $parts.append(new Option('-- Select Part --', '', true, true)).trigger('change');

                    response.data.forEach(function (item) {
                        let partName = '', partId = '';

                        if (item.model === 'part' && item.part) {
                            partName = item.part.nameParts;
                            partId = item.part.id;
                        } else if (item.model === 'equipment' && item.equipment) {
                            partName = item.equipment.name;
                            partId = item.equipment.id;
                        } else if (item.model === 'tools' && item.tools) {
                            partName = item.tools.name;
                            partId = item.tools.id;
                        } else if (item.model === 'facility' && item.facility) {
                            partName = item.facility.name;
                            partId = item.facility.id;
                        }

                        if (partName && partId) {
                            partDetails[partId] = {
                                qty: item.qty || 0,
                                unit_price: item.unit_price || 0
                            };
                            $parts.append(new Option(partName, partId, false, false));
                        }
                    });


                    $parts.prop('disabled', false); // aktifkan dropdown kembali
                },
                error: function() {
                    $parts.empty().append(new Option('Failed to load parts', '', true, true)).prop('disabled', true).trigger('change');
                }
            });
        }
        $('#parts').change(function () {
            let selectedPartId = $(this).val();
            if (selectedPartId && partDetails[selectedPartId]) {
                $('#qty').val(partDetails[selectedPartId].qty);
                $('#unit_price').val(partDetails[selectedPartId].unit_price);
            } else {
                $('#qty').val('');
                $('#unit_price').val('');
            }
        });


        $('#po_number').change(function () {
            let selectedPOs = $(this).val();
            if (selectedPOs.length > 0) {
                loadParts(selectedPOs);
            } else {
                $('#po_items').empty();
            }
        });

        $('#parts').select2({
            placeholder: 'Select Part',
            allowClear: true
        });
        $('#add').click(function (e) {
            e.preventDefault();

            let partId = $('#parts').val();
            let partName = $('#parts option:selected').text();
            let qty = parseFloat($('#qty').val());
            let unitPrice = $('#unit_price').val();
            let receivedTo = parseFloat($('#received_to').val());

            // Ambil batas maksimum qty dari detail part (misal: poItemQty)
            let poItemQty = partDetails[partId] ? parseFloat(partDetails[partId].qty) : 0;

            if (!partId || !qty || !unitPrice || !receivedTo) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Input',
                    text: 'Please fill in all required fields.'
                });
                return;
            }

            if (receivedTo > qty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Input',
                    text: 'Received quantity cannot be greater than ordered quantity.'
                });
                return;
            }

            if (qty > poItemQty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Quantity',
                    text: `Quantity cannot be greater than PO quantity (${poItemQty}).`
                });
                return;
            }


            let totalReceivedBefore = 0;
            $('#po_items tr').each(function () {
                let existingPartId = $(this).find('input[name="parts[]"]').val();
                let existingQty = parseFloat($(this).find('input[name="received_to[]"]').val());
                if (existingPartId === partId) {
                    totalReceivedBefore += existingQty;
                }
            });

            // Validasi: totalReceivedBefore + receivedTo tidak boleh lebih dari poItemQty
            if (totalReceivedBefore + receivedTo > poItemQty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Exceeded PO Quantity',
                    text: `Total received (${totalReceivedBefore + receivedTo}) exceeds ordered quantity (${poItemQty}).`
                });
                return;
            }


            let newRow = `
        <tr>
            <td>
                ${partName}
                <input type="hidden" name="parts[]" value="${partId}">
            </td>
            <td>
                ${qty}
                <input type="hidden" name="qty_received[]" value="${qty}">
            </td>
            <td>
                ${unitPrice}
                <input type="hidden" name="unit_price[]" value="${unitPrice}">
            </td>
            <td>
                ${receivedTo}
                <input type="hidden" name="received_to[]" value="${receivedTo}">
            </td>
            <td>
                <button class="btn btn-sm btn-danger remove-line">Remove</button>
            </td>
        </tr>
    `;

            $('#po_items').append(newRow);
            let currentTotal = parseFloat($('#total_price').val()) || 0;
            let newTotal = currentTotal + (qty * unitPrice);
            $('#total_price').val(newTotal.toFixed(2));

            // Clear input fields
            $('#parts').val(null).trigger('change');
            $('#qty').val('');
            $('#unit_price').val('');
            $('#received_to').val('');
        });

        $(document).on('click', '.remove-line', function () {
            $(this).closest('tr').remove();
        });
    });



</script>
<script>
    function goBack() {
        window.history.back();
    }

    function confirmSave() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("myForm").submit();
            }
        });
    }
</script>


<style>
    .small-card { font-size: 0.85rem; padding: 5px; }
    .small-text { font-size: 0.8rem; }
    .btn-sm { padding: 4px 8px; font-size: 0.75rem; }
    .form-control-sm { font-size: 0.8rem; padding: 4px; }
</style>
