@extends('admin.layouts.app')
@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Change Password</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="bs-validation">
                <div class="row">
                    <!-- Bootstrap Validation -->
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                       <form class="validate-form" method="post" action="{{ route('admin-change-password') }}" novalidate="novalidate">
    @csrf
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label for="account-old-password">Old Password</label>
                <div class="input-group form-password-toggle input-group-merge">
                    <input
                        type="password"
                        class="form-control @error('old_password') is-invalid @enderror"
                        id="old_password"
                        name="old_password"
                        placeholder="Old Password" required
                    />
                    <div class="input-group-append" style="margin-left: -2px;">
                        <div class="input-group-text cursor-pointer" style="height: 40px;">
                            <i data-feather="eye"></i>
                        </div>
                    </div>
                </div>
                @error('old_password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="account-new-password">New Password</label>
                <div class="input-group form-password-toggle input-group-merge">
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="form-control @error('new_password') is-invalid @enderror"
                        placeholder="New Password" required
                    />
                    <div class="input-group-append" style="margin-left: -2px;">
                        <div class="input-group-text cursor-pointer"  style="height: 40px;">
                            <i data-feather="eye"></i>
                        </div>
                    </div>
                </div>
                @error('new_password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <label for="account-retype-new-password">Retype New Password</label>
                <div class="input-group form-password-toggle input-group-merge">
                    <input
                        type="password"
                        class="form-control"
                        id="confirm_password"
                        name="new_password_confirmation"
                        placeholder="Retype New Password" required
                    />
                    <div class="input-group-append" style="margin-left: -2px;">
                        <div class="input-group-text cursor-pointer" style="height: 40px;"><i data-feather="eye"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary mr-1 mt-1">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
             </section>                   
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
<!-- <script type="text/javascript">
    $('.validate-form').validate()
</script> -->
@endsection