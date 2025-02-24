@extends('layout.layout')

@php
    $title = 'Scheduled Maintenance List';
    $subTitle = 'Scheduled Maintenance List';

@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
          <a href="{{ route('scheduler.create') }}" class="btn btn-primary btn-sm">
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
                        <th scope="col">When</th>
                        <th scope="col">SM Status</th>
                        <th scope="col">Code</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Asset</th>
                        <th scope="col">Assign User</th>
                        <th scope="col">Time Estimated User</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Next Trigger Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>2023-01-01</td>
                        <td>Completed</td>
                        <td>SM-1</td>
                        <td>High</td>
                        <td>Asset 1</td>
                        <td>User 1</td>
                        <td>2 hours</td>
                        <td>Preventive</td>
                        <td>Description 1</td>
                        <td>2023-01-02 8:00 AM</td>
                    </tr>


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

    });
</script>

