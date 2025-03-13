@extends('layout.layout')

@php
    $title = 'List Business';
    $subTitle = 'List Business';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
          <a href="{{ route('business.create') }}" class="btn btn-outline-success btn-sm">
            <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>
          </a>

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
                       <th scope="col">Code</th>
                       <th scope="col">Qrcode</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($business as $key => $value)

                        <tr>
                            <th scope="row">
                                        {{ $key+1 }}
                            </th>
                            <td>
                                {{ $value->code }}
                            </td>
                            <td>
                                {{ \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($value->code) }}
                            </td>
                            <td>{{ $value->business_name ?? '' }}</td>
                            <td>{{ $value->address ?? ''}}</td>
                            <td>{{ $value->city ?? ''}}</td>
                            <td>{{ $value->country ?? ''}}</td>
                            <td>
                                @if($value->status == 1)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{  route('business.edit', $value->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <a href="{{ route('business.destroy', $value->id) }}" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:trash-2"></iconify-icon>
                                </a>
                            </td>
                        </tr>

                    @endforeach
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
    //     dataTable
        $('#dataTable').DataTable();

    });
</script>

