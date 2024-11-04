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
                        <h2 class="content-header-title float-left mb-0">Manage Batch #{{$batch->id}}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Manage Batch #{{$batch->id}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
           <!-- Advanced Search -->
            <section id="advanced-search-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!--Search Form -->
                            <div class="card-body mt-2">
                                <form class="dt_adv_search" method="POST" id="sfrm">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-row mb-1">
                                                <div class="col-lg-4">
                                                    <label>Manufacturing Date:</label>
                                                    <p>{{$batch->manufacturing}}</p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Expiry Date:</label>
                                                    <p>{{$batch->expiry}}</p>
                                                </div>

                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="search">Search</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="reset">Reset</button>
                                        </div> --}}
                                    </div>
                                </form>
                            </div>
                            <hr class="my-0" />
                            <div class="card-datatable">
                                <table class="dt-advanced-search table" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product</th>
                                            <th>Code</th>
                                            <th>IP Address</th>
                                            <th>Location</th>

                                            <th>Is Verified</th>
                                            <th>Verified At</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Advanced Search -->
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
    var oTable = $('#users-table').DataTable({
        dom: "<'row'<'col-12'<'col-6 f'l><'col-6 p dn'p>>r>"+
            "<'row'<'col-12't>>"+
            "<'row'<'col-12 foot'<'col-6 f'i><'col-6 p'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{route('getbatchpro')}}',
            data: function (d) {
                d.firstname = $('input[name=firstname]').val();
                d.lastname = $('input[name=lastname]').val();
                d.id = {{$batch->id}};
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            //{data: 'prefix', name: 'prefix'},
            {data: 'product.name', name: 'product.name'},
            {data: 'code', name: 'code'},
            {data: 'ip_address', name: 'ip_address', orderable: false, searchable: false},
            {data: 'location', name: 'location', orderable: false, searchable: false},
            {data: 'is_verified', name: 'is_verified'},
            {data: 'updated_at', name: 'updated_at'},
            // {data: 'action', name: 'action', orderable: false, searchable: false}
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
</script>
@endsection
