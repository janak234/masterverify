@extends('admin.layouts.app')
@section('content')
<style>
    /* Custom Animation */
    .modal.fade .modal-dialog {
      transform: scale(0.9);
      opacity: 0;
      transition: all 0.3s ease-in-out;
    }
    .modal.show .modal-dialog {
      transform: scale(1);
      opacity: 1;
    }
  </style>
 <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-xl-12 mb-4 col-lg-12 col-12">
                    <div class="card h-100">
                      <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                          <h5 class="card-title mb-0">Statistics</h5>
                        </div>
                         <div class="col-lg-4">
                          <select name="select_brand" id="select_brand" class="form-control dt-input dt-full-name" id="">
                              <option value="">--Brand Selector--</option>  
                              @foreach($brands as $key=>$value)
                               <option value="{{$value}}">{{$value}}</option>  
                              @endforeach
                          </select>
                      </div>
                      </div>
                     
                      <style> .badged i{height: 1.45rem; width: 1.45rem; font-size: 1.45rem; margin-right: 1.1rem; -webkit-flex-shrink: 0; -ms-flex-negative: 0; flex-shrink: 0;} .badgex{margin-right: 5px;} .badgex .feather, [data-feather] {height: 2rem; width: 2rem; display: inline-block; }</style>
                      <div class="card-body">
                        <div class="row gy-3">
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badgex">
                                <i data-feather="layers"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0 total_product">{{$result['total_product']}}</h5>
                                <small>Total Products</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0 product_verified">{{$result['product_verified']}}</h5>
                                <small>Products Verified</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0 codes_generated">{{$result['codes_generated']}}</h5>
                                <small> Codes Generated</small>
                              </div>
                            </div>
                          </div>
                            <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0 total_scan">{{$result['total_scan']}}</h5>
                                <small>Current Month Scan</small>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="row">
                          <div class="col-md-12 col-12">
                            <a href="{{route('export_all_code')}}"><button  type="button" class="btn btn-success"><i data-feather="file-text"></i>&nbsp;Export All Verified Code</button></a>
                          </div>
                        </div>  
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
                                <h4 class="card-title">Scan By State</h4>
                            </div>
                         
                            <hr class="my-0" />
                            <div class="card-datatable">
                                <table class="dt-advanced-search table" id="users-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>State</th>
                                            <th>No OF Verify</th>
                                            <th>View</th>
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
        <div class="content-body">
           <div id="map" style="height: 500px;"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal Title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="dt-advanced-search table" id="detail-table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Brand</th>
                      <th>Strain</th>
                      <th>No of Scan</th>
                  </tr>
              </thead>
              <tbody class="detail-body">
                
              </tbody>
          </table>
        </div>
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
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script type="text/javascript">
     const states  = @json($metrix); // Pass metrix data to JavaScript
      $('#select_brand').on('change',function(){
          $.get("{{route('dashboard')}}",{brand:$(this).val()},function(result){
              if(result){
                 $.each(result,function(i,v){
                    $('.'+i).text(v);
                 })
              }
          });
      });
      var oTable = $('#users-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url: "{{route('get_state_wise')}}",
          },
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'state', name: 'state'},
              {data: 'product_count', name: 'product_count'},
              {data: 'action', name: 'action', orderable: false, searchable: false}
          ],
          drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
          }

      });
      // $(document).on('click','.view_detail',function(){
      //   state=$(this).attr('id');
      //   $('#exampleModalLabel').text(state?state:'Unknown');
      //   $('.detail-body').empty();
      //   $.get("{{route('get_state_wise_detail')}}",{state:state},function(result){
      //       if(result){
      //         $.each(result, function(index, item) {
      //             var row = '<tr>';
      //             row += '<td>' + (index+1) + '</td>';
      //             row += '<td>' + item.brand + '</td>';
      //             row += '<td>' + item.name + '</td>';
      //             row += '<td>' + item.count + '</td>';
      //             row += '</tr>';
      //             $('.detail-body').append(row);
      //         });
      //         $('#detail-table').DataTable();
      //       }
      //   });
      //   $('#exampleModal').modal('show');
      // })
      $(document).on('click', '.view_detail', function() {
          if ($.fn.dataTable.isDataTable('#detail-table')) {
            $('#detail-table').DataTable().clear().destroy();
          }
            var state = $(this).attr('id');
            $('#exampleModalLabel').text(state?state:'Unknown');
            var table = $('#detail-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get_state_wise_detail') }}",
                    type: "GET",
                    data: function(d) {
                        d.state = state;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'brand', name: 'brand' },
                    { data: 'name', name: 'name' },
                    { data: 'count', name: 'count' }
                ]
            });
            $('#exampleModal').modal('show');
      });
    </script>
    <script>
    const map = L.map('map').setView([37.0902, -95.7129], 4);; 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
    }).addTo(map);
    states.forEach(state => {
      L.circleMarker([state.lat, state.lon], {
        radius: state.metric,
        fillColor: 'blue',
        color: 'blue',
        weight: 1,
        fillOpacity: 0.6,
      })
      .bindPopup(`${state.name}: Metric = ${state.metric}`).addTo(map);
    });
  </script>
@endsection
