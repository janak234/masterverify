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
                        <h2 class="content-header-title float-left mb-0">Manage Product</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Manage Product</a>
                                </li>
                                <li class="breadcrumb-item active">Add/Edit Product</li>
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
                                <form method="POST" action="{{route('products.update',$user->id)}}" name="userForm"
                                    enctype="multipart/form-data" class="needs-validation" novalidate="">
                                    {{method_field('put')}}
                                    @else
                                    <form method="POST" action="{{route('products.index')}}" name="userForm"
                                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                                        @endif
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Strain</label>
                                                <input type="text" name="name"
                                                    class="form-control @if($errors->has('name')) error @endif"
                                                    placeholder="Product Name" aria-label="name" required=""
                                                    value="{{$user->name}}">
                                                @if($errors->has('name'))
                                                <label id="name-error" class="error"
                                                    for="name">{{ $errors->first('name') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">Product Size</label>
                                                <input type="text" name="weight"
                                                    class="form-control @if($errors->has('weight')) error @endif"
                                                    placeholder="Weight" aria-label="weight" required=""
                                                    value="{{$user->weight}}">
                                                @if($errors->has('weight'))
                                                <label id="weight-error" class="error"
                                                    for="weight">{{ $errors->first('weight') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="type">Product</label>
                                                <input type="text" name="type" id="type"
                                                    class="form-control @if($errors->has('type')) error @endif"
                                                    placeholder="Type" aria-label="type" required=""
                                                    value="{{$user->type}}">
                                                @if($errors->has('type'))
                                                <label id="type-error" class="error"
                                                    for="type">{{ $errors->first('type') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="brand">Brand</label>
                                                <input type="text" name="brand" id="brand"
                                                    class="form-control @if($errors->has('brand')) error @endif"
                                                    placeholder="Brand" aria-label="brand"
                                                    value="{{$user->type}}">
                                                @if($errors->has('tybrandpe'))
                                                <label id="brand-error" class="error"
                                                    for="brand">{{ $errors->first('brand') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <label class="form-label" for="basic-default-password1">Image</label>
                                                <input type="file" name="image"
                                                    class="form-control" @if(!$user->image) required @endif>
                                                <div class="invalid-feedback">Please upload image.</div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                @if($user->image)
                                                    <img src="/{{$user->image}}" alt="" style="width: 200px">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                                <a href="{{route('products.index')}}"
                                                    class="btn btn-primary waves-effect waves-float waves-light">Back</a>
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
                //     'basic-default-type': {
                //       required: true,
                //       type: true
                //     },
                //     'basic-default-password': {
                //       required: true
                //     },
                //   }
            });
        }
    });
    $(window).on('load', function () {
        $('#basic-default-password1').val('');
    })
</script>
@endsection
