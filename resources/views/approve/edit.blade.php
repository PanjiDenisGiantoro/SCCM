@extends('layout.layout2')

@php
    $title = 'List Approve';
    $subTitle = 'List Approve';

@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <style>
        span {
            display: inline;
        }
    </style>

    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="card">
                <form id="purchaseRequestForm" action="{{ route('approve.store_sequence') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name Process</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" readonly value="{{ $approve->process_name ?? '' }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <input type="text" name="id" value="{{ $approve->process_id }}" hidden>
                            </div>

                            @if(empty($approve->layers))
                            <div class="col-md-12 mt-3">
                                <label>Choose Approvers</label>
                                <div id="approver-container">
                                    @for ($i = 0; $i < ($approve->required_approvals ?? 1); $i++)
                                        <div class="form-group">
                                            <label for="approver-{{ $i+1 }}">Approve No {{ $i+1 }}</label>
                                            <select name="approvers[]" id="approver-{{ $i+1 }}" class="form-select select2">
                                                <option value="">-- Select Approver --</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user['id'] }}">{{ $user['name'] }} - {{ $user->roles[0]->name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            @else
                            <div class="col-md-12 mt-3 text-center">
                                <p class="text-danger">
                                    if you want to reset this process, please click reset button
                                </p>
                            </div>
                                @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @if(empty($approve->layers))
                        <button type="submit" class="btn btn-outline-info">Submit</button>
                        @endif
                        <a href="{{ route('approve.list') }}" class="btn btn-outline-danger">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="card basic-data-table mt-3">
                <div class="card-header d-flex justify-content-between">
                    <h6>
                        {{ $approve->process_name ?? "" }}
                    </h6>
                    <a href="{{ url('approve/destroy_sequence/'.$approve->process_id) }}" class="btn btn-outline-danger">Reset</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name </th>
                                <th scope="col">Role </th>
                                <th scope="col">Sequence Order</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($approve->layers as $layer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $layer->user->name ?? '' }}</td>
                                    <td>{{ $layer->user->roles->first()->name   ?? '' }}</td>
                                    <td>{{ $layer->sequence_order + 1 ?? '' }}</td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tambahkan di bagian head -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            dropdownParent: $('body') // Pastikan dropdown tidak berada dalam elemen tersembunyi
        });


    });
</script>
