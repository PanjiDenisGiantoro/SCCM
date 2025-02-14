@extends('layout.layout')

@php
    $title = 'List Client';
    $subTitle = 'List Client';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0"></h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">

            <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                <tr>
                    <th scope="col">
                        <div class="form-check style-check d-flex align-items-center">
                            <label class="form-check-label">
                                No
                            </label>
                        </div>
                    </th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">lifetime</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        </div>
    </div>

@endsection
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // Tambahkan opsi ini untuk responsivitas

            ajax: "{{ route('client.getData') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nameClient', name: 'nameClient' },
                { data: 'emailClient', name: 'emailClient' },
                { data: 'lifetime', name: 'lifetime' },
                { data: 'statusClient', name: 'statusClient' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>

