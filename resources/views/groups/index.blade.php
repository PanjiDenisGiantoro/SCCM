@extends('layout.layout2')

@php
    $title = 'Department';
    $subTitle = 'Department';
@endphp

@section('content')

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Department Form</h6>
                </div>
                <div class="card-body">
                    @if(!empty($data))
                        <form action="{{ route('groups.update', $data->id) }}" method="post" id="clientForm">
                            @csrf
                            @method('PUT')
                            @else
                                <form action="{{ route('groups.store') }}" method="post" id="clientForm">
                                    @csrf
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Name Department <span
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


        // $('#submit').on('click', function () {
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "Do you want to submit the form?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, submit it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $('#clientForm').submit();
        //         }
        //     });
        // });
    });
</script>
