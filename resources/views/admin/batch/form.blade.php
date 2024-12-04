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
                                                    value="{{$user->prefix?$user->prefix:old('prefix')}}">
                                                @if($errors->has('prefix'))
                                                <label id="prefix-error" class="error"
                                                    for="prefix">{{ $errors->first('prefix') }}</label>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-2">
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


                                            <div class="form-group col-md-2">
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
                                            <div class="form-group col-md-2">
                                                <label class="form-label" for="no_code"> No of Codes </label>
                                                <input type="number" name="no_code"
                                                    class="form-control @if($errors->has('no_code')) error @endif"
                                                    placeholder=" No of Codes " id="no_code" aria-label="no_code"
                                                    value="{{old('no_code')}}" min="1" max="100000">
                                                @if($errors->has('no_code'))
                                                <label id="no_code-error" class="error"
                                                    for="no_code">{{ $errors->first('no_code') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input class="form-control dt-input" type="file" name="excel_file" id="excel_file" accept="xls,.xlsx,.csv">
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
                                        </div>

                                         <div class="card-datatable">
                                             @if($errors->has('products'))
                                        <label id="products-error" class="error"
                                            for="products">{{ $errors->first('products') }}</label>
                                        @endif
                                <table class="dt-advanced-search table" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Strain</th>
                                            <th>Product Image</th>
                                            <th>Product Size</th>
                                            <th>Product</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>    
                                        
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
<div class="modal fade" id="excel_import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Code</h5>
      </div>
      <form method="POST" action="{{route('import_code')}}" enctype="multipart/form-data" id="uploadForm">
      @csrf 
      <div class="modal-body">
        <label>Import Code From Excel</label>
        <input class="form-control dt-input" type="file" name="excel_file" id="excel_file" accept="xls,.xlsx,.csv" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary dismiss" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<link href="{{ asset('admin/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet">
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script>
    var currentPage = {{ $Products->currentPage() }};

    $(document).ready(function() {
        var oTable = $('#users-table').DataTable({
        dom: "<'row'<'col-12'<'col-6 f'l><'col-6 p dn'p>>r>"+
            "<'row'<'col-12't>>"+
            "<'row'<'col-12 foot'<'col-6 f'i><'col-6 p'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{route('getproducts')}}',
            data: function (d) {
                d.firstname = $('input[name=firstname]').val();
                d.lastname = $('input[name=lastname]').val();
                d.email = $('input[name=email]').val();
            }
        },
        columns: [
            {
                data: 'id',
                name: 'select',
                render: function (data, type, row) {
                    return `<input type="radio" name="products" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            {data: 'name', name: 'name'},
            {data: 'image', name: 'image'},
            {data: 'weight', name: 'weight'},
            {data: 'type', name: 'type'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]

    });

    $('#search').click(function() {
        oTable.draw();
        e.preventDefault();
    });
    $('#reset').click(function() {
        $('input[name=firstname]').val('');
        $('input[name=lastname]').val('');
        $('input[name=email]').val('');
        oTable.draw();
    });
    $('#users-table').on('draw.dt', function() {
     $('[data-toggle="tooltip"]').tooltip();
     if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
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
