@extends('layout.layout')

@php
    $title = 'View Profile';
    $subTitle = 'View Profile';

@endphp

@section('content')

    <div class="row gy-4">
        <div class="col-lg-4">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <img src="{{ asset('assets/images/auth/auth.png') }}" alt="" class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="{{ asset('storage/' . $users->profile_photo_path) }}" alt="User Image"
                             class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16">{{ $users->name ?? '-' }}</h6>
                        <span class="text-secondary-light mb-16">{{ $users->email ?? '-' }}</span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Personal Info</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $users->name ?? '-' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $users->email ?? '-' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Company</span>
                                <span class="w-70 text-secondary-light fw-medium">: @if(!empty($users->companies))
                                        {{ $users->companies->nameClient ?? '' }}
                                    @else
                                        {{ $users->company_child->nameClient ?? '-' }}
                                    @endif</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Department</span>
                                <span
                                    class="w-70 text-secondary-light fw-medium">: {{ $users->userOrganitations->name ?? '' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Division</span>
                                <span
                                    class="w-70 text-secondary-light fw-medium">: {{ $users->divisions->name ?? '' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Role</span>
                                <span
                                    class="w-70 text-secondary-light fw-medium">: {{$users->roles[0]->name ?? ''}}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Description Division</span>
                                <span
                                    class="w-70 text-secondary-light fw-medium">: {{ $users->divisions->description ?? '' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body p-24">
                    <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab"
                                    aria-controls="pills-edit-profile" aria-selected="true">
                                Edit Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-change-passwork-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button"
                                    role="tab" aria-controls="pills-change-passwork" aria-selected="false"
                                    tabindex="-1">
                                Change Password
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab"
                                    aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Diagram Organization
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center px-24" id="pills-company-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-company" type="button" role="tab"
                                    aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Detail Company
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                             aria-labelledby="pills-edit-profile-tab" tabindex="0">
                            <h6 class="text-md text-primary-light mb-16">Profile Image</h6>
                            <!-- Upload Image Start -->
                            <div class="mb-24 mt-16">
                                <div class="avatar-upload">

                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{ asset('storage/' . $users->profile_photo_path) }});"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Upload Image End -->
                            <form action="{{  route('user.update_profile', $users->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" required
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', $users->name ?? '') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" required
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $users->email ?? '') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password
                                            <span class="text-danger"> ( if empty then not update )
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password"
                                                   @if(empty($users)) required @endif
                                                   class="form-control @error('password') is-invalid @enderror">
                                            <button type="button" class="btn btn-outline-secondary"
                                                    onclick="togglePassword()">
                                                <iconify-icon id="toggleIcon" icon="lucide:eye"></iconify-icon>
                                            </button>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Role <span class="text-danger">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" name="role"
                                                required>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option
                                                    value="{{ $role->id }}" {{ old('role', $users->roles[0]->id ?? '') == $role->id ? 'selected' : '' }}>
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
                                               value="{{ old('profile_photo_path', $users->profile_photo_path ?? '') }}">
                                        @error('profile_photo_path')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" name="status"
                                                required>
                                            <option
                                                value="0" {{ old('status', $users->status ?? '0') == '0' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                            <option
                                                value="1" {{ old('status', $users->status ?? '0') == '1' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                        </select>
                                        @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Department <span class="text-danger">*</span></label>
                                        <select class="form-select" name="organization_id" id="organization_id" required
                                                style="width: 100%">
                                            <option value="">Select Departments</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ old('departments', $users->organization_id ?? '') == $department->id ? 'selected' : '' }}>
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
                                        <select class="form-select" name="division_id" id="division"
                                                style="width: 100%">
                                            @if(!empty($users->division_id))
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('divisions', $users->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="">Select Division</option>

                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('user.list') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Back
                                    </a>
                                    <button type="submit"
                                            class="btn btn-outline-success border border-primary-600 text-md px-56 py-12 radius-8">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel"
                             aria-labelledby="pills-change-passwork-tab" tabindex="0">
                            <form action="{{ route('user.password', $users->id) }}" method="post">
                                <div class="mb-20">
                                    @csrf
                                    @method('PUT')
                                    <label for="your-password"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">New Password
                                        <span class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="your-password"
                                               name="password" placeholder="Enter New Password*">
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                            data-toggle="#your-password"></span>
                                    </div>
                                </div>
                                <div class="mb-20">
                                    <label for="confirm-password"
                                           class="form-label fw-semibold text-primary-light text-sm mb-8">Confirmed
                                        Password <span class="text-danger-600">*</span></label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control radius-8" id="confirm-password"
                                               name="confirm" placeholder="Confirm Password*">
                                        <span
                                            class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                            data-toggle="#confirm-password"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="btn btn-outline-success border border-primary-600 text-md px-56 py-12 radius-8">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="pills-notification" role="tabpanel"
                             aria-labelledby="pills-notification-tab" tabindex="0">
                            <div id="tree">

                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-company" role="tabpanel"
                             aria-labelledby="pills-company-tab" tabindex="0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="name"
                                               class="form-label fw-semibold text-primary-light text-sm mb-8">Name
                                            Company</label>
                                        <input type="text" class="form-control radius-8" id="name"
                                               placeholder="Enter Full Name" readonly
                                               value="@if(!empty($users->companies)) {{ $users->companies->nameClient ?? '' }}@else {{ $users->company_child->nameClient ?? '-' }} @endif">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="email"
                                               class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                            Company</label>
                                        <input type="email" class="form-control radius-8" id="email"
                                               placeholder="Enter email address" readonly
                                               value="@if(!empty($users->companies)) {{ $users->companies->emailClient ?? '' }}@else {{ $users->company_child->emailClient ?? '-' }} @endif">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="number"
                                               class="form-label fw-semibold text-primary-light text-sm mb-8">Phone
                                            Company</label>
                                        <input type="email" class="form-control radius-8" id="number"
                                               placeholder="Enter phone number" readonly
                                               value="@if(!empty($users->companies)) {{ $users->companies->phoneClient ?? '' }}@else {{ $users->company_child->phoneClient ?? '-' }} @endif">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-20">
                                        <label for="desc"
                                               class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                                        <textarea name="#0" class="form-control radius-8" id="desc"
                                                  placeholder="Write description..." readonly>@if(!empty($users->companies))
                                                {{ $users->companies->addressClient ?? '' }}
                                            @else
                                                {{ $users->company_child->addressClient ?? '-' }}
                                            @endif
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://balkan.app/js/OrgChart.js"></script>
<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>

<script>
    $(document).ready(function () {

        var initialDepartmentId = $('#organization_id').val();
        if (initialDepartmentId) {
            $('#organization_id').trigger('change');
        }


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
    });
    document.addEventListener("DOMContentLoaded", function () {
        fetch("{{ url('organitation/dataStructure') }}")
            .then(response => response.json())
            .then(data => {
                new OrgChart(document.getElementById("tree"), {
                    nodes: data,
                    nodeBinding: {
                        field_0: "name",
                        field_1: "title"
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
