@extends('layout.layout2')

@php
    $title = 'User Management';
    $subTitle = 'Create or Edit User';

@endphp

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">User Form</h6>
                </div>
                <div class="card-body">
                    @if(!empty($user))
                        <form action="{{ route('user.update', $user->id) }}" method="post" id="userForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @else
                                <form action="{{ route('user.store') }}" method="post" id="userForm" enctype="multipart/form-data">
                                    @csrf
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" required
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', $user->name ?? '') }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" required
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email', $user->email ?? '') }}">
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" @if(empty($user)) required @endif
                                                class="form-control @error('password') is-invalid @enderror">
                                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                                    <iconify-icon id="toggleIcon" icon="lucide:eye"></iconify-icon>
                                                </button>
                                            </div>
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Role <span class="text-danger">*</span></label>
                                            <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}" {{ old('role', $user->role ?? '') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Profile Photo Path</label>
                                            <input type="file" name="profile_photo_path"
                                                   class="form-control @error('profile_photo_path') is-invalid @enderror"
                                                   value="{{ old('profile_photo_path', $user->profile_photo_path ?? '') }}">
                                            @error('profile_photo_path')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                                <option value="0" {{ old('status', $user->status ?? '0') == '0' ? 'selected' : '' }}>Inactive</option>
                                                <option value="1" {{ old('status', $user->status ?? '0') == '1' ? 'selected' : '' }}>Active</option>
                                            </select>
                                            @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Department <span class="text-danger">*</span></label>
                                            <select class="form-select" name="organization_id" id="organization_id"  required style="width: 100%">
                                                <option value="">Select Departments</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                            {{ old('departments', $user->departments ?? '') == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('organization_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <small class="text-muted">*Please select at least one department</small>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">Division</label>
                                            <select class="form-select" name="division_id" id="division" style="width: 100%">
                                                <option value="">Select Division</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mt-4 d-flex justify-content-end">
                                            @if(!empty($user))
                                                <button type="submit" class="btn btn-outline-success">Update</button>
                                            @else
                                                <button type="submit" class="btn btn-outline-success">Submit</button>
                                            @endif
                                            <a href="{{ route('user.list') }}" class="btn btn-outline-secondary ms-2">Back</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
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
</script>
<script>
        @if(!empty($disable))
        $('input, textarea, select').prop('disabled', true);
        @endif
</script>
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.setAttribute("icon", "lucide:eye-off");
        } else {
            passwordInput.type = "password";
            toggleIcon.setAttribute("icon", "lucide:eye");
        }
    }

</script>

