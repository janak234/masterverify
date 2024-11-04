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
                        <h2 class="content-header-title float-left mb-0">Manage Admin</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Manage Admin</a></li>
                                <li class="breadcrumb-item active">Add/Edit Admin</li>
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
                                @if(isset($user->id))
                                        <form  method="POST" action="{{route('users.update',$user->id)}}" name="userForm" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                            {{method_field('put')}}
                                            @else
                                                <form method="POST" action="{{route('users.index')}}" name="userForm" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                                    @endif
                                                    {{csrf_field()}}


                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Firstname</label>

                                            <input type="text" name="firstname" class="form-control @if($errors->has('firstname')) error @endif" placeholder="Firstname"
                                                aria-label="Firstname" required="" value="{{$user->firstname}}">
                                                @if($errors->has('firstname'))
                                                <label id="firstname-error" class="error" for="firstname">{{ $errors->first('firstname') }}</label>
                                                @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Lastname</label>

                                            <input type="text" name="lastname"  class="form-control @if($errors->has('lastname')) error @endif" placeholder="Lastname"
                                                aria-label="Lastname" required="" value="{{$user->lastname}}">

                                                @if($errors->has('lastname'))
                                                <label id="lastname-error" class="error" for="lastname">{{ $errors->first('lastname') }}</label>

                                                @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control @if($errors->has('email')) error @endif"
                                                placeholder="Email" aria-label="Email"
                                                required="" value="{{$user->email}}">
                                                @if($errors->has('email'))
                                            <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>

                                                @endif

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="basic-default-password1">Password</label>
                                            <input type="password" name="password" id="basic-default-password1" class="form-control"
                                                placeholder="············" @if(!isset($user->id)) required="" @endif>
                                            <div class="invalid-feedback">Please enter password.</div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="select-country1">Role</label>
                                            <select name="role_id" class="form-control @if($errors->has('role_id')) error @endif" id="select-country1" required="">
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{ucwords($role->name)}}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('role_id'))
                                            <label id="role_id-error" class="error" for="firstname">{{ $errors->first('role_id') }}</label>

                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label" for="basic-default-password1">Mobile</label>
                                            <input type="number" name="mobile" id="basic-default-password1" class="form-control"
                                                placeholder="Mobile"  value="{{$user->mobile}}">

                                            <div class="invalid-feedback">Please enter mobile.</div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                            <a href="{{route('users.index')}}" class="btn btn-primary waves-effect waves-float waves-light">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /Bootstrap Validation -->


                </div>
            </section>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>

<script>
    $(function () {
        'use strict';

        var jqForm = $('.needs-validation'),
            select = $('.select2');
        // select2
        select.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this
                .select2({
                    placeholder: 'Select value',
                    dropdownParent: $this.parent()
                })
                .change(function () {
                    $(this).valid();
                });
        });
        // Bootstrap Validation
        // --------------------------------------------------------------------
        if (jqForm.length) {
    jqForm.validate({
    //   rules: {
    //     'basic-default-name': {
    //       required: true
    //     },
    //     'basic-default-email': {
    //       required: true,
    //       email: true
    //     },
    //     'basic-default-password': {
    //       required: true
    //     },
    //   }
    });
  }

});


    $(window).on('load', function() {
        $('#basic-default-password1').val('');
        })

</script>
@endsection
