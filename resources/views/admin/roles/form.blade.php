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
                        <h2 class="content-header-title float-left mb-0">Manage Role</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Manage Role</a></li>
                                <li class="breadcrumb-item active">Add/Edit Role</li>
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
                                @if(isset($role->id))
                                        <form  method="POST" action="{{route('roles.update',$role->id)}}" name="userForm" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                            {{method_field('put')}}
                                            @else
                                                <form method="POST" action="{{route('roles.index')}}" name="userForm" enctype="multipart/form-data" class="needs-validation" novalidate="">
                                                    @endif
                                                    {{csrf_field()}}


                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label">Name</label>

                                            <input type="text" name="name" class="form-control @if($errors->has('name')) error @endif" placeholder="name"
                                                aria-label="name" required="" value="{{$role->name}}">
                                                @if($errors->has('name'))
                                                <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                                @endif
                                        </div>

                                    </div>




                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                            <a href="{{route('roles.index')}}" class="btn btn-primary waves-effect waves-float waves-light">Back</a>
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
