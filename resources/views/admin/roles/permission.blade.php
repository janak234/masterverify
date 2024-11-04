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
                        <h2 class="content-header-title float-left mb-0">Manage Permission</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Manage Role</a></li>
                                <li class="breadcrumb-item active">Manage Permission</li>
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
                                <div class="table-responsive border rounded px-1" style="padding: 0 !important">
                                    @php
                                    if($permission->id){
                                    $accessString = $permission->access;
                                    $access = explode(',',$accessString);
                                    $listString = $permission->list;$list = explode(',',$listString);
                                    $searchString = $permission->search;$search = explode(',',$searchString);
                                    $viewString = $permission->view;$view = explode(',',$viewString);
                                    $addString = $permission->add;$add = explode(',',$addString);
                                    $editString = $permission->edit;$edit = explode(',',$editString);
                                    $deleteString = $permission->delete;$delete = explode(',',$deleteString);
                                    $statusString = $permission->status;$status = explode(',',$statusString);
                                    $exportString = $permission->export;$export = explode(',',$exportString);
                                    }
                                    @endphp
                                    <form name="riaPermission" style="padding-bottom: 20px;" method="post"
                                        action="{{route('permission_update')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="PUT">
                                        <table id="permissionTable" class="table table-borderless">
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" value="{{$permission->id}}">
                                            <thead>
                                                <tr>
                                                    <th>Modules</th>
                                                    <th>Access</th>
                                                    <th>View</th>
                                                    <th>Add</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>Status</th>
                                                    <th>Export</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tables as $table)
                                                <tr>
                                                    <th>{{$table->title}}</th>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_access" name="access[]"
                                                                {{in_array($table->slug,$access) ? 'checked' : ''}}>
                                                            <label class="custom-control-label"
                                                                for="{{$table->slug}}_access"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_view" name="view[]"
                                                                {{in_array($table->slug,$view) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_view"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_add" name="add[]"
                                                                {{in_array($table->slug,$add) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_add"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_edit" name="edit[]"
                                                                {{in_array($table->slug,$edit) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_edit"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_delete" name="delete[]"
                                                                {{in_array($table->slug,$delete) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_delete"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_status" name="status[]"
                                                                {{in_array($table->slug,$status) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_status"></label>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox"><input
                                                                type="checkbox" class="custom-control-input"
                                                                value="{{$table->slug}}" id="{{$table->slug}}_export" name="export[]"
                                                                {{in_array($table->slug,$export) ? 'checked' : ''}}> <label
                                                                class="custom-control-label" for="{{$table->slug}}_export"></label>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                        <div class="col-12" style="margin-top: 20px">
                                            <button type="submit" class="btn btn-primary waves-effect waves-float waves-light">Submit</button>
                                            <a href="{{route('roles.index')}}" class="btn btn-primary waves-effect waves-float waves-light">Back</a>
                                        </div>
                                    </form>
                                </div>
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
    $(window).on('load', function () {
        $('#basic-default-password1').val('');
    })
</script>
@endsection
