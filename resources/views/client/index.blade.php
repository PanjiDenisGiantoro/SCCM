@extends('layout.layout2')

@php
    $title = 'Client';
    $subTitle = 'Client';
@endphp

@section('content')

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Client Form</h6>
                </div>
                <div class="card-body">
                    @if(!empty($data))
                        <form action="{{ route('client.update', $data->id) }}" method="post" id="clientForm">
                            @csrf
                            @method('PUT')
                            @else
                                <form action="{{ route('client.store') }}" method="post" id="clientForm">
                                    @csrf
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Name Client <span class="text-danger">*</span></label>
                                            <input type="text" name="nameClient" required
                                                   @if(!empty($data)) value="{{ $data->nameClient }}" @else value="{{ old('nameClient') }}" @endif
                                                   class="form-control @error('nameClient') is-invalid @enderror">
                                            @error('nameClient')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email Client  <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                    <span class="input-group-text bg-base">
                                        <iconify-icon icon="mynaui:envelope"></iconify-icon>
                                    </span>
                                                <input type="text" name="emailClient" required
                                                       @if(!empty($data)) value="{{ $data->emailClient }}" @else value="{{ old('emailClient') }}" @endif
                                                       class="form-control flex-grow-1 @error('emailClient') is-invalid @enderror"
                                                       placeholder="info@gmail.com">
                                            </div>
                                            @error('emailClient')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone Client  <span class="text-danger">*</span></label>
                                            <input type="text" required
                                                   class="form-control flex-grow-1 @error('phoneClient') is-invalid @enderror"
                                                   name="phoneClient"
                                                   @if(!empty($data)) value="{{ $data->phoneClient }}" @else value="{{ old('phoneClient') }}" @endif
                                                   placeholder="+62 123 4567">
                                            @error('phoneClient')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
{{--                                        form codeclient--}}
                                        <div class="col-md-6">
                                            <label class="form-label">Code Client  <span class="text-danger">*</span></label>
                                            <input type="text" name="codeClient" readonly
                                                   @if(!empty($data)) value="{{ $data->codeClient }}"
                                                   @else
                                                       value="{{ $numberCode }}"
                                                   @endif
                                                   class="form-control @error('codeClient') is-invalid @enderror">
                                            @error('codeClient')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Date Client  <span class="text-danger">*</span></label>
                                            <input type="date" name="dateClient" required
                                                   @if(!empty($data)) value="{{ $data->dateClient }}" @else value="{{ old('dateClient') }}" @endif
                                                   class="form-control @error('dateClient') is-invalid @enderror">
                                            @error('dateClient')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status Client  <span class="text-danger">*</span></label>
                                            <select class="form-select" name="statusClient">
                                                <option value=""
                                                        @if(!empty($data) && $data->statusClient == '') selected @endif>
                                                    Select Status
                                                </option>
                                                <option value="1"
                                                        @if(!empty($data) && $data->statusClient == 1) selected @endif>
                                                    Active
                                                </option>
                                                <option value="0"
                                                        @if(!empty($data) && $data->statusClient == 0) selected @endif>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Lifetime (Years)  <span class="text-danger">*</span></label>
                                            <input type="number" name="lifetime" required
                                                   @if(!empty($data)) value="{{ $data->lifetime }}" @else value="{{ old('lifetime') }}" @endif
                                                   class="form-control @error('lifetime') is-invalid @enderror"
                                                   placeholder="0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Type Client  <span class="text-danger">*</span></label>
                                            <select class="form-select" name="typeClient">
                                                <option value=""
                                                        @if(!empty($data) && $data->typeClient == '') selected @endif>
                                                    Select Type
                                                </option>
                                                <option value="on-premise"
                                                        @if(!empty($data) && $data->typeClient == 'on-premise') selected @endif>
                                                    On Premise
                                                </option>
                                                <option value="cloud"
                                                        @if(!empty($data) && $data->typeClient == 'cloud') selected @endif>
                                                    Cloud
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Address Client</label>
                                            <textarea class="form-control @error('addressClient') is-invalid @enderror"
                                                      name="addressClient" rows="3">@if(!empty($data)){{ $data->addressClient }}@endif
                                            </textarea>
                                        </div>
                                        <div class="col-12 mt-24 d-flex justify-content-end">
                                            @if(!empty($data) && empty($disable))
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                            @elseif(empty($data) && empty($disable))
                                                <button type="submit" id="submit" class="btn btn-primary">Submit
                                                </button>
                                            @else
                                                <div class="col-12 mt-24 d-flex justify-content-end">
                                                    <a href="{{ route('client.list') }}" class="btn btn-secondary">Back</a>
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
