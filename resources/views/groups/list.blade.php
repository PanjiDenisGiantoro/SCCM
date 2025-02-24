@extends('layout.layout')

@php
    $title = 'List Organization';
    $subTitle = 'List Organization';
@endphp

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <div class="card basic-data-table">
        <div class="card-header d-flex justify-content-end">
            <a href="{{ route('groups.create') }}" class="btn-sm  d-flex align-items-center btn btn-primary">
                <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon>Add Organization
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th></th> <!-- Expand icon -->
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- DataTables will fill this -->
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

<style>
    /* Custom styles for smaller and cleaner child rows */
    .child-table, .user-table {
        background-color: #f9f9f9;
        margin-top: 5px;
        border-collapse: collapse;
        width: 95%;
    }

    .child-table th, .child-table td,
    .user-table th, .user-table td {
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    .child-table tr:nth-child(even),
    .user-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .dt-control-user {
        cursor: pointer;
        font-weight: bold;
        color: #007bff;
    }

    .dt-control-user:hover {
        color: #0056b3;
    }

    .user-row {
        background-color: #eef6ff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.2rem 0.5rem;
    }
</style>

<script>
    $(document).ready(function () {
        function formatChildRow(orgId) {
            return `<table class="table table-sm table-bordered child-table" id="child-${orgId}">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;"></th> <!-- Expand icon for users -->
                            <th>Division Name</th>
                            <th>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="me-2">Users</span>
                                    <a href="{{ route('division.list') }}" class="btn-sm d-flex align-items-center btn btn-primary">
                                        <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg line-height-1"></iconify-icon> Add Division
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="3" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>`;
        }

        function formatUserRow(users) {
            let rows = '';
            users.forEach(user => {
                rows += `<tr>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                    </tr>`;
            });
            return `<table class="table table-sm table-bordered user-table">
                    <thead class="table-light">
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                         <th>
    <div class="d-flex justify-content-between align-items-center">
        <span class="me-2">Role</span>
        <a href="{{ route('user.list') }}" class="btn btn-primary btn-sm d-flex align-items-center">
            <iconify-icon icon="fa6-regular:square-plus" class="icon text-lg me-1"></iconify-icon>
            Add User
        </a>
    </div>
</th>

                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>`;
        }

        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('groups.getData') }}",
            columns: [
                {
                    data: null,
                    className: 'dt-control',
                    orderable: false,
                    defaultContent: '<span class="dt-control-user">+</span>'
                },
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Expand organization row
        $('#dataTable tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                $(this).find('.dt-control-user').text('+');
            } else {
                var orgId = row.data().id;
                row.child(formatChildRow(orgId)).show();
                tr.addClass('shown');
                $(this).find('.dt-control-user').text('-');

                $.ajax({
                    url: "{{ route('groups.getDivisionsUsers') }}",
                    data: {org_id: orgId},
                    success: function (data) {
                        var childTable = $(`#child-${orgId} tbody`);
                        childTable.empty();

                        if (data.length > 0) {
                            data.forEach(item => {
                                var userExpandIcon = item.users.length > 0 ? '<span class="dt-control-user">+</span>' : '';
                                childTable.append(`
                                <tr data-division-id="${item.id}">
                                    <td class="dt-control-user">${userExpandIcon}</td>
                                    <td>${item.name}</td>

                                    <td>${item.description}</td>
                                </tr>
                                <tr class="user-row" style="display: none;">
                                    <td colspan="3">${formatUserRow(item.users)}</td>
                                </tr>
                            `);
                            });
                        } else {
                            childTable.append('<tr><td colspan="3" class="text-center">No Data Found</td></tr>');
                        }
                    },
                    error: function () {
                        $(`#child-${orgId} tbody`).html('<tr><td colspan="3" class="text-center text-danger">Error loading data</td></tr>');
                    }
                });
            }
        });

        // Expand user row
        $(document).on('click', '.dt-control-user', function () {
            var tr = $(this).closest('tr');
            var userRow = tr.next('.user-row');

            if (userRow.is(':visible')) {
                userRow.hide();
                $(this).text('+');
            } else {
                userRow.show();
                $(this).text('-');
            }
        });
    });
</script>

