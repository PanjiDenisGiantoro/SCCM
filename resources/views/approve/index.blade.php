@extends('layout.layout2')

@php
    $title = 'List Approve';
    $subTitle = 'List Approve';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card">
                <form id="purchaseRequestForm" action="{{ route('approve.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name Process</label>
                                  <select class="form-select @error('name') is-invalid @enderror" id="name" name="name">
                                    <option value="">-- Pilih Name Process --</option>
                                      <option value="PR">Purchase Request</option>
                                      <option value="PO">Purchase Order</option>
                                      <option value="WO">Work Order</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total">Total Approval</label>
                                    <input type="number" class="form-control @error('total') is-invalid @enderror" id="total" name="total">
                                    @error('total')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="budget">Min Budget</label>
                                <input type="text" class="form-control @error('budget') is-invalid @enderror" id="budget" name="budget">
                                @error('budget')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_budget">Max Budget</label>
                                <input type="text" class="form-control @error('max_budget') is-invalid @enderror" id="max_budget" name="max_budget">
                                @error('max_budget')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="submitBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card basic-data-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                            <thead>
                            <tr>
                                <th scope="col">Name Process</th>
                                <th scope="col">Total Approval</th>
                                <th scope="col">Min Budget</th>
                                <th scope="col">Max Budget</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($approve as $list)
                                <tr>
                                    <td>{{ $list->process_name ?? '-'}}</td>
                                    <td>{{ $list->required_approvals ?? '-' }}</td>
                                    <td>{{ $list->budget ? number_format($list->budget, 0, ',', '.') : '-' }}</td>
                                    <td>{{ $list->max_budget ? number_format($list->max_budget, 0, ',', '.') : '-' }}</td>
                                    <td>
                                        <a href="{{ url('approve/edit/'.$list->process_id) }}" class="btn btn-outline-info">View</a>
                                        <a href="{{ url('approve/destroy/'.$list->process_id) }}" class="btn btn-outline-danger">Delete</a>
                                    </td>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->


    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js"></script>

    <script>
        document.querySelectorAll("#budget, #max_budget").forEach(function(input) {
            input.addEventListener("input", function() {
                let bilangan = this.value.replace(/\D/g, ""); // Hapus semua karakter selain angka
                if (bilangan === "") {
                    this.value = ""; // Jika kosong, tetap kosong
                    return;
                }

                let numberString = bilangan.toString();
                let rupiah = "";
                let sisa = numberString.length % 3;
                rupiah = numberString.substr(0, sisa);
                let ribuan = numberString.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                this.value = rupiah;
            });
        });
    </script>

    <script>


        $(document).ready(function () {



            // Inisialisasi DataTables
            $('#dataTable').DataTable();

            // Konfirmasi SweetAlert sebelum submit form
            $("#purchaseRequestForm").on("submit", function(event) {
                event.preventDefault(); // Mencegah form submit langsung

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to submit this purchase request?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit(); // Submit form jika dikonfirmasi
                    }
                });
            });
        });

    </script>
@endsection
