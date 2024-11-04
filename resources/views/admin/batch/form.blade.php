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
                        <h2 class="content-header-title float-left mb-0">Manage Batch</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('batch.index')}}">Manage Batch</a>
                                </li>
                                <li class="breadcrumb-item active">Add/Edit Batch</li>
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
                                <form method="POST" action="{{route('batch.update',$user->id)}}" name="userForm"
                                    enctype="multipart/form-data" class="needs-validation" novalidate="">
                                    {{method_field('put')}}
                                    @else
                                    <form method="POST" action="{{route('batch.index')}}" name="userForm"
                                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                                        @endif
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label class="form-label">Prefix Name</label>
                                                <input type="text" name="prefix"
                                                    class="form-control @if($errors->has('prefix')) error @endif"
                                                    placeholder="Prefix Name" aria-label="prefix"
                                                    value="{{$user->prefix}}">
                                                @if($errors->has('prefix'))
                                                <label id="prefix-error" class="error"
                                                    for="prefix">{{ $errors->first('prefix') }}</label>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="form-label" for="type">Manufacturing Date</label>
                                                <input type="date" name="manufacturing" id="manufacturing"
                                                    class="form-control @if($errors->has('manufacturing')) error @endif"
                                                    placeholder="manufacturing" aria-label="manufacturing"
                                                    value="{{$user->manufacturing}}">
                                                @if($errors->has('manufacturing'))
                                                <label id="manufacturing-error" class="error"
                                                    for="manufacturing">{{ $errors->first('manufacturing') }}</label>
                                                @endif
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label class="form-label" for="expiry">Expiry Date</label>
                                                <input type="date" name="expiry"
                                                    class="form-control @if($errors->has('expiry')) error @endif"
                                                    placeholder="expiry" id="expiry" aria-label="expiry"
                                                    value="{{$user->expiry}}">
                                                @if($errors->has('expiry'))
                                                <label id="expiry-error" class="error"
                                                    for="expiry">{{ $errors->first('expiry') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="form-label" for="no_code"> No of Codes </label>
                                                <input type="number" name="no_code"
                                                    class="form-control @if($errors->has('no_code')) error @endif"
                                                    placeholder=" No of Codes " id="no_code" aria-label="no_code"
                                                    value="" min="1" max="100000">
                                                @if($errors->has('no_code'))
                                                <label id="no_code-error" class="error"
                                                    for="no_code">{{ $errors->first('no_code') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                            <label class="form-label">Select Product</label>
<style>
.form-control.c {
	position: absolute;
	top: 0;
	right: 0;
	width: 25px;
	height: 25px;
}.card-body label {
	display: none;
}.card-body .qt {
	display: none;
}
.col-md-3 .card .card-title {
	margin-bottom:0;
}
</style>
                                        @if($errors->has('products'))
                                        <label id="products-error" class="error"
                                            for="products">{{ $errors->first('products') }}</label>
                                        @endif
                                        </div>
                                            @foreach ($Products as $Product)
                                            <div class="col-md-3 col-lg-3 mb-3" >
                                                <div class="card h-100" >
                                                  <img class="card-img-top" src="/{{$Product->image}}" alt="{{$Product->name}}" style="height: 200px;object-fit: cover;" onclick="select({{$Product->id}})">
                                                  <div class="card-body" style="background: #f2f2f2;">
                                                    <h5 class="card-title">{{$Product->name}}</h5>
                                                    <input required type="radio" name="products" class="form-control c" id="p{{$Product->id}}" value="{{$Product->id}}" style="margin-bottom: 5px">
                                                <label for="">No of Codes</label>
                                                    <input  type="text" name="qty[]" class="form-control qt" value="1" required min="1">
                                                  </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <div id="productContainer"></div>
                                            @if ($Products->hasMorePages())
                                            <div class="form-group col-md-12">
                                                <button class="btn btn-secondary" type="button" id="loadMoreBtn">Load More</button>
                                            </div>
                                        @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                                <a href="{{route('batch.index')}}"
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
<script>
    var currentPage = {{ $Products->currentPage() }};

    $(document).ready(function() {
        $('#loadMoreBtn').on('click', function() {
            currentPage++;
            $.ajax({
                url: '{{route('loadMore')}}?page=' + currentPage,
                type: 'GET',
                success: function(data) {
                    $('#productContainer').after(data);
                    if (!data.trim()) {
                        $('#loadMoreBtn').hide();
                    }
                }
            });
        });
    });

</script>
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
    function select(id){

        $("#p"+id).prop("checked", !$("#p"+id).prop("checked"));
    }
</script>
@endsection
