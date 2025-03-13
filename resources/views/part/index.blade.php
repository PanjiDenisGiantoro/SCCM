@extends('layout.layout')

@php
    $title = 'List Part';
    $subTitle = 'List Part';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('part.create') }}" class="btn btn-outline-success btn-sm">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>

                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">QRcode</th>
                        {{--                                                <th scope="col">Last Price Currency</th>--}}
                        {{--                                                <th scope="col">Total Stock</th>--}}
                        {{--                                                <th scope="col">Stock Location</th>--}}
                        {{--                                                <th scope="col">Aisle</th>--}}
                        {{--                                                <th scope="col">Row</th>--}}
                        {{--                                                <th scope="col">Bin Number</th>--}}
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
            // latest data
            order: [0, 'desc'],

            ajax: "{{ route('part.getData') }}",
            columns: [

                {data: 'code', name: 'code'},
                {data: 'nameParts', name: 'nameParts'},
                {data: 'qrcode', name: 'qrcode'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

    });
</script>

