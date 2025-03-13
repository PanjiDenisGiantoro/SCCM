@extends('layout.layout2')

@php
    $title = 'Division';
    $subTitle = 'Division';
@endphp

@section('content')

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Division Form</h6>
                </div>
                <div class="card-body">
                    @if(!empty($data))
                        <form action="{{ route('division.update', $data->id) }}" method="post" id="clientForm">
                            @csrf
                            @method('PUT')
                            @else
                                <form action="{{ route('division.store') }}" method="post" id="clientForm">
                                    @csrf
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Name Division <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" required
                                                   @if(!empty($data)) value="{{ $data->name }}"
                                                   @else value="{{ old('name') }}" @endif
                                                   class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                            <select name="organization_id" id="organization_id" class="form-select @error('organization_id') is-invalid @enderror">
                                                <option value="">Select Departments</option>

                                                @if(!empty($data))
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                                {{ $data->organization_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                                    @endif
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                      name="description" rows="3">@if(!empty($data)){{ $data->description }}@endif</textarea>
                                        </div>
                                        <div class="col-12 mt-24 d-flex justify-content-end">
                                            @if(!empty($data) && empty($disable))
                                                <button type="submit" class="btn btn-outline-success">Update</button>
                                            @elseif(empty($data) && empty($disable))
                                                <button type="submit" id="submit" class="btn btn-outline-success">Submit
                                                </button>
                                            @else
                                                <div class="col-12 mt-24 d-flex justify-content-end">
                                                    <a href="{{ route('client.list') }}"
                                                       class="btn btn-secondary">Back</a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </form>
                </div>
            </div><!-- card end -->
        </div>
    </div>

@endsection

<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        @if(!empty($disable))
        $('input, textarea, select').prop('disabled', true);
        @endif

        $(document).ready(function () {
            $('#organization_id').on('change', function () {
                var departmentId = $(this).val();
                if (departmentId) {
                    $.ajax({
                        url: '/organitation/getDivision/' + departmentId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#division').empty();
                            $('#division').append('<option value="">Select Division</option>');
                            $.each(data, function (key, division) {
                                $('#division').append('<option value="' + division.id + '">' + division.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#division').empty();
                    $('#division').append('<option value="">Select Division</option>');
                }
            });
            $(".select2").select2(
                {
                    width: '100%',
                    placeholder: "Select Departments",
                    allowClear: true,
                    multiple: true
                }
            );
        });
    });
</script>
