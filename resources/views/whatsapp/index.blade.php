@extends('layout.layout2')

@php
    $title = 'Whatsapp Config';
    $subTitle = 'Whatsapp Config';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card">
                <form id="purchaseRequestForm" action="{{ route('wa.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="no_wa">No. Whatsapp</label>
                                    <input type="number" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa">
                                    @error('no_wa')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info" id="submitBtn">Save</button>
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
                                <th scope="col">Whatsapp</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($whatsapp as $list)
                                <tr>
                                    <td>{{ $list->no_wa ?? '-' }}</td>
                                    <td>
                                        @if($list->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('wa/viewVerify/'.$list->id) }}" class="btn btn-outline-info">View</a>
                                        <a href="{{ url('wa/destroy/'.$list->id) }}" class="btn btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
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
