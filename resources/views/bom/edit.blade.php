@extends('layout.layout2')

@php
    $title = 'BOM Group';
    $subTitle = 'BOM Group';
    // Ambil record BOM yang memiliki part (quantity tidak null) dan yang memiliki facility (quantity null)

@endphp
@section('content')
    <!-- Header -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <a href="{{ route('bom.list') }}" class="btn btn-dark m-2">Back</a>
                <button class="btn btn-outline-info m-2 btn-submit">Submit</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Field Nama BOM (misal, dari BOM parts atau facility, disesuaikan) -->
            <div class="form-group mb-3 w-60">
                <label for="name">Name</label>
                <!-- Contoh: gunakan nama dari BOM parts -->
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ $bomParts[0]->name ?? '-'  }}" readonly>
            </div>
        </div>
    </div>

    <!-- Tabs: Parts List dan Asset BOM -->
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="part-tab" data-bs-toggle="tab" data-bs-target="#part" type="button" role="tab" aria-controls="part" aria-selected="true">
                        Parts List
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="asset-tab" data-bs-toggle="tab" data-bs-target="#asset" type="button" role="tab" aria-controls="asset" aria-selected="false">
                        Asset BOM
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- Parts Tab -->
                <div class="tab-pane fade show active" id="part" role="tabpanel" aria-labelledby="part-tab">
                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addPartModal">Add Part</button>
                    <div class="table-responsive">
                        <table class="table basic-table mb-2" id="partTable">
                            <thead>
                            <tr>
                                <th>Part Name</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Tampilkan data parts dari $bomParts --}}

                            @if($bomParts)
                                @foreach($bomParts as $item)

                                    <tr data-id="{{ $item->id }}" data-index="{{ $loop->index }}">
                                        <td>
                                            <input type="hidden" name="parts[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                            <input type="text" class="form-control" name="parts[{{ $loop->index }}][name]" value="{{ $item->nameParts }}" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control qty-input" name="parts[{{ $loop->index }}][qty]" min="1" value="{{ $item->quantity ?? 1 }}">
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger removePartBtn">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
{{--                            @if($bomParts && $bomParts->parts && $bomParts->parts->count())--}}
{{--                                @foreach($bomParts->parts as $index => $part)--}}
{{--                                    <tr data-id="{{ $part->id }}" data-index="{{ $index }}">--}}
{{--                                        <td>--}}
{{--                                            <input type="hidden" name="parts[{{ $index }}][id]" value="{{ $part->id }}">--}}
{{--                                            <input type="text" class="form-control" name="parts[{{ $index }}][name]" value="{{ $part->nameParts }}" readonly>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <input type="number" class="form-control qty-input" name="parts[{{ $index }}][qty]" min="1" value="{{ $bomParts->quantity ?? 1 }}">--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <button class="btn btn-sm btn-danger removePartBtn">Remove</button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Asset BOM Tab -->
                <div class="tab-pane fade" id="asset" role="tabpanel" aria-labelledby="asset-tab">
                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addAssetModal">Add Asset</button>
                    <div class="table-responsive">
                        <table class="table basic-table mb-2" id="assetTable">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Asset</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Tampilkan data asset dari $currentBomFacility --}}
                            @if($bomFacilities)
                                @foreach($bomFacilities as $item)
                                    <tr data-id="{{ $item->bom_id }}" data-index="{{ $loop->index }}">
                                        <td>
                                            <input type="hidden" name="bom[{{ $loop->index }}][id]" value="{{ $item->bom_id }}">
                                            <input class="form-control" type="text" name="bom[{{ $loop->index }}][code]" value="{{ $item->code }}" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bom[{{ $loop->index }}][name]" value="{{ $item->name }}" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bom[{{ $loop->index }}][category]" value="{{ $item->category_name }}" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bom[{{ $loop->index }}][asset]" value="{{ $item->bom_id  }}" readonly>
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" name="bom[{{ $loop->index }}][location]" value="{{ $item->id_location }}" readonly>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger removeBomBtn">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <input type="hidden" name="bom[][id]" value="{{ $currentBomFacility->facilities->id }}">--}}
{{--                                        <input class="form-control" type="text" name="bom[][code]" value="{{ $currentBomFacility->facilities->code }}">--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <input class="form-control" type="text" name="bom[][name]" value="{{ $currentBomFacility->facilities->name }}">--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <input class="form-control" type="text" name="bom[][category]" value="{{ $currentBomFacility->facilities->category }}">--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <input class="form-control" type="text" name="bom[][asset]" value="{{ $currentBomFacility->id_asset ?? $currentBomFacility->facilities->id_asset }}">--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <input class="form-control" type="text" name="bom[][location]" value="{{ $currentBomFacility->facilities->id_location }}">--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Part -->
    <div class="modal fade" id="addPartModal" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartModalLabel">Add Part</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="modalPartTable">
                            <thead>
                            <tr>
                                <th>Part Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Data part akan dimuat dengan AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Asset -->
    <div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Asset BOM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="modalAssetTable">
                            <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Data asset akan dimuat dengan AJAX dari database -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let partIndex = {{ $bomParts->count() ?? 0 }};

        // ========================
        // Modal Part: Load List Part via AJAX
        // ========================
        $('#addPartModal').on('show.bs.modal', function () {
            loadPartList();
        });

        function loadPartList() {
            $.ajax({
                url: "{{ url('api/list_part') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let tableBody = $("#modalPartTable tbody");
                    tableBody.empty();
                    response.forEach(part => {
                        tableBody.append(`
                            <tr>
                                <td>${part.nameParts}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info addPartBtn"
                                        data-id="${part.id}"
                                        data-name="${part.nameParts}">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function () {
                    alert("Failed to load parts list.");
                }
            });
        }

        // Tambahkan Part ke tabel utama
        $(document).on("click", ".addPartBtn", function () {
            let partId = $(this).data("id");
            let partName = $(this).data("name");

            // Cek apakah part sudah ada
            let exists = false;
            $("#partTable tbody tr").each(function () {
                if ($(this).data("id") == partId) {
                    exists = true;
                }
            });

            if (!exists) {
                partIndex++;
                $("#partTable tbody").append(`
                    <tr data-id="${partId}" data-index="${partIndex}">
                        <td>
                            <input type="hidden" name="parts[${partIndex}][id]" value="${partId}">
                            <input type="text" class="form-control" name="parts[${partIndex}][name]" value="${partName}" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control qty-input" name="parts[${partIndex}][qty]" min="1" value="1">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger removePartBtn">Remove</button>
                        </td>
                    </tr>
                `);
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Entry',
                    text: 'This part is already in the list!',
                });
            }
            $('#addPartModal').modal('hide');
        });

        // Hapus Part
        $(document).on("click", ".removePartBtn", function () {
            $(this).closest("tr").remove();
        });

        // ========================
        // Modal Asset: Load Facility Data via AJAX
        // ========================
        $("#addAssetModal").on("show.bs.modal", function () {
            $.ajax({
                url: "{{ url('bom/getlistBom') }}", // Endpoint untuk data facility dari database
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let tbody = $("#modalAssetTable tbody");
                    tbody.empty();
                    response.forEach((facility, index) => {
                        let row = `
                            <tr>
                                <td>${facility.code}</td>
                                <td>${facility.name}</td>
                                <td>${facility.category}</td>
                                <td>${facility.id_location ? facility.id_location : '-'}</td>
                                <td>
                                    <button class="btn btn-outline-info btn-add-asset" data-asset='${JSON.stringify(facility)}'>Add</button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                },
                error: function () {
                    alert("Failed to load assets from database.");
                }
            });
        });

        // Tambahkan Asset (Facility) ke tabel utama
        $(document).on("click", ".btn-add-asset", function () {
            let facilityData = $(this).data("asset");
            if (typeof facilityData === "string") {
                facilityData = JSON.parse(facilityData);
            }
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="bom[][id]" value="${facilityData.id}">
                        <input class="form-control" type="text" name="bom[][code]" value="${facilityData.code}"readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="bom[][name]" value="${facilityData.name}"readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="bom[][category]" value="${facilityData.category}"readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="bom[][asset]" value="${facilityData.code}"readonly>
                    </td>
                    <td>
                        <input class="form-control" type="text" name="bom[][location]" value="${facilityData.id_location ? facilityData.id_location : ''}" readonly>
                    </td>
                    <td>
                            <button class="btn btn-sm btn-danger removeBomBtn">Remove</button>
                        </td>
                </tr>
            `;
            $("#assetTable tbody").append(row);
            $("#addAssetModal").modal("hide");


        });

        // Hapus Part
        $(document).on("click", ".removeBomBtn", function () {
            $(this).closest("tr").remove();
        });
        // ========================
        // Submit Data (Edit BOM)
        // ========================
        $(".btn-submit").on("click", function () {
            let parts = [];
            let assets = [];
            let name = $('input[name="name"]').val();

            $("#partTable tbody tr").each(function () {
                let partId = $(this).data("id");
                let qty = $(this).find(".qty-input").val();
                parts.push({ id: partId, qty: qty });
            });

            $("#assetTable tbody tr").each(function () {
                let assetId = $(this).find("input[name='bom[][id]']").val();
                assets.push({ id: assetId });
            });

            if(name.length == 0){
                Swal.fire({
                    icon: 'warning',
                    title: 'No Name',
                    text: 'Please add a name before submitting.',
                });
                return;
            }

            if (parts.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Parts Selected',
                    text: 'Please add at least one part before submitting.',
                });
                return;
            }

            $.ajax({
                url: "{{ route('bom.store') }}", // Endpoint untuk simpan/update BOM
                type: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: JSON.stringify({ parts: parts, assets: assets, name: name }),
                contentType: "application/json",
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'BOM saved successfully!',
                    }).then(() => { location.reload(); });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save parts. Please try again.',
                    });
                }
            });
        });
    });
</script>
