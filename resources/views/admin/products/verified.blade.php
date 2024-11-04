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
                        <h2 class="content-header-title float-left mb-0">Verified Products</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Verified Products</li>
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
                            <div class="card-header border-bottom">
                                <h4 class="card-title">Search</h4>

                            </div>
                            <!--Search Form -->
                            <div class="card-body mt-2">
                                <form class="dt_adv_search" method="POST" id="sfrm">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-row mb-1">
                                                <div class="col-lg-4">
                                                    <label>Product:</label>
                                                    <select name="product" id="product" class="form-control dt-input dt-full-name" id="">
                                                        <option value="">--Select--</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label>Date:</label>
                                                    <input type="date" name="date" class="form-control dt-input" data-column="2" placeholder="" data-column-index="1" />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="search">Search</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" id="reset">Reset</button>
                                        </div>
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
            url: '{{route('getverifiedproducts')}}',
            data: function (d) {
                d.product = $('#product').val();
                d.date = $('input[name=date]').val();

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
        ],order: [
            [0, "DESC"]
        ]

    });

    $('#search').click(function() {
        oTable.draw();
        e.preventDefault();
    });
    $('#reset').click(function() {
        $('#product').val('');
        $('input[name=date]').val('');
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
