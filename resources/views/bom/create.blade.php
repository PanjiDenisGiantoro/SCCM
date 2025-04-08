@extends('layout.layout2')

@php
    $title = 'BOM Group';
    $subTitle = 'BOM Group';
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-end">
                <button class="btn btn-dark m-2">Back</button>
                <button class="btn btn-outline-success m-2 btn-submit">Submit</button>
            </div>
        </div>
        <div class="card-body">

            <div class="form-group mb-3 w-60">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>

        </div>
    </div>

    <!-- Tabs -->
    <div class="card mt-3">
        <div class="card-body">

            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="part-tab" data-bs-toggle="tab" data-bs-target="#part"
                            type="button" role="tab" aria-controls="part" aria-selected="true">Parts List
                    </button>
                </li>
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <button class="nav-link" id="asset-tab" data-bs-toggle="tab" data-bs-target="#asset"--}}
{{--                            type="button" role="tab" aria-controls="asset" aria-selected="false">Asset BOM--}}
{{--                    </button>--}}
{{--                </li>--}}
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- Part Tab -->
                <div class="tab-pane fade show active" id="part" role="tabpanel" aria-labelledby="part-tab">
                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addPartModal">Add
                        Part
                    </button>
                    <div class="table-responsive">
                        <!-- Tabel utama untuk menampilkan daftar part yang dipilih -->
                        <table class="table basic-table mb-2" id="partTable">
                            <thead>
                            <tr>
                                <th>Part Name</th>
                                <th>Qty</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Data akan ditambahkan lewat JS -->
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
                            <!-- Data akan dimuat dengan AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Add Part Modal -->
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
                            <!-- Data akan dimuat dengan AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add Asset Modal -->
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
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let partIndex = 0; // Untuk memberikan indeks unik pada setiap part yang ditambahkan

        // Saat modal dibuka, muat daftar part dari API
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
                    tableBody.empty(); // Kosongkan table sebelum load data baru
                    response.forEach(part => {
                        tableBody.append(`
                            <tr>
                                <td>${part.nameParts}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success addPartBtn"
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

        // Event handler untuk tombol "Add" di modal
        $(document).on("click", ".addPartBtn", function () {
            let partId = $(this).data("id");
            let partName = $(this).data("name");

            // Cek apakah part sudah ada di tabel utama
            let exists = false;
            $("#partTable tbody tr").each(function () {
                if ($(this).data("id") == partId) {
                    exists = true;
                }
            });

            if (!exists) {
                partIndex++; // Tambahkan indeks unik

                $("#partTable tbody").append(`
                    <tr data-id="${partId}" data-index="${partIndex}">
                        <td>
                            <input type="hidden" name="parts[${partIndex}][id]" value="${partId}">${partName}
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

            $('#addPartModal').modal('hide'); // Tutup modal setelah add
        });

        // Event handler untuk tombol "Remove" di tabel utama
        $(document).on("click", ".removePartBtn", function () {
            $(this).closest("tr").remove();
        });

        // Event handler untuk tombol Submit
        $(".btn-submit").on("click", function () {
            let parts = [];
            let assets = [];
            let name = $('input[name="name"]').val();

            $("#partTable tbody tr").each(function () {
                let partId = $(this).data("id");
                let qty = $(this).find(".qty-input").val();

                parts.push({
                    id: partId,
                    qty: qty
                });
            });

            $("#assetTable tbody tr").each(function () {
                let assetId = $(this).find("input[name='bom[][asset]']").val();

                assets.push({
                    id: assetId
                })

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


            // Kirim data dengan AJAX ke backend
            $.ajax({
                url: "{{ route('bom.store') }}", // Ganti dengan endpoint backend
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: JSON.stringify({ parts: parts, assets: assets, name: name }),
                contentType: "application/json",
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'BOM saved successfully!',
                    }).then(() => {
                        window.location.href = "{{ route('bom.list') }}";
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save parts. Please try again.',
                    }).
                    then(() => {
                        window.location.href = "{{ route('bom.list') }}";
                    });
                }
            });
        });
    });
    $(document).ready(function () {
        // Saat modal dibuka, ambil data facility dari database lewat AJAX
        $("#addAssetModal").on("show.bs.modal", function () {
            $.ajax({
                url: "{{ url('bom/getlistBom') }}", // Endpoint untuk data facility
                type: "GET",
                dataType: "json",
                success: function (response) {
                    let tbody = $("#modalAssetTable tbody");
                    tbody.empty(); // Bersihkan tabel terlebih dahulu
                    response.forEach((facility, index) => {
                        console.log(facility);
                        let row = `
                        <tr>
                            <td>${facility.code}</td>
                            <td>${facility.name}</td>
                            <td>${facility.categories?.category_name ? facility.categories.category_name : ''}</td>
                            <td>${facility.id_location ? facility.id_location : '-'}</td>
                            <td>
                                <button class="btn btn-outline-success btn-add-asset" data-asset='${JSON.stringify(facility)}'>Add</button>
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

        // Event listener untuk tombol "Add" facility dari modal
        $(document).on("click", ".btn-add-asset", function () {
            let facilityData = $(this).data("asset");
            // Pastikan facilityData sudah berbentuk objek
            if (typeof facilityData === "string") {
                facilityData = JSON.parse(facilityData);
            }
            // Tambahkan facility ke tabel utama (Asset BOM) dengan hidden input untuk id
            let row = `
            <tr>
                <td>
                    <input type="hidden" name="bom[][id]" value="${facilityData.id}">${facilityData.code}
                </td>
                <td>
                    <input class="form-control"  type="hidden" type="text" name="bom[][name]" value="${facilityData.name}">${facilityData.name}
                </td>
                <td>
                    <input class="form-control"  type="hidden" type="text" name="bom[][category]" value="${facilityData.categories?.category_name ? facilityData.categories.category_name : ''}">${facilityData.categories?.category_name ? facilityData.categories.category_name : ''}
                </td>
                <td>
                    ${facilityData.code}
                    <input type="hidden" class="form-control" type="text" name="bom[][asset]" value="${facilityData.id}">
                </td>
                <td>
                    <input class="form-control" type="hidden" type="text" name="bom[][location]" value="${facilityData.id_location ? facilityData.id_location : ''}">${facilityData.id_location ? facilityData.id_location : ''}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove-asset">Remove</button>
                </td>

            </tr>
        `;
            $(document).on("click", ".btn-remove-asset", function () {
                $(this).closest("tr").remove();
            });
            $("#assetTable tbody").append(row);
            $("#addAssetModal").modal("hide"); // Tutup modal setelah facility ditambahkan
        });
    });

</script>
