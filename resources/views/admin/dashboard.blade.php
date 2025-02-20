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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                      <form id="form_filter" method="post" action="{{route('export_all_code')}}">
                        @csrf
                      <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                          <h5 class="card-title mb-0">Statistics</h5>
                        </div>
                        
                        <div class="col-lg-6" style="display: flex ; justify-content:space-evenly;margin-top: -50px;">
                          <div>
                           <p class="card-text font-small-2 me-25 mb-0">
                            <input type="text" id="date-range" class="form-control Filter" name="date" /></p>
                         </div>
                         <div>
                          <select name="select_brand" id="select_brand" class="form-control dt-input dt-full-name" id="">
                              <option value="">--Brand Selector--</option>  
                              @foreach($brands as $key=>$value)
                               <option value="{{$value}}">{{$value}}</option>  
                              @endforeach
                          </select>
                          </div>
                        </div>
                       
                      </div>
                       </form>
                     
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
                            <a href="javascript:void(0);" onclick="document.getElementById('form_filter').submit();"><button  type="button" class="btn btn-success"><i data-feather="file-text"></i>&nbsp;Export Verified Code</button></a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
     const states  = @json($metrix);
     var brand_name=""
     var start_date=""
     var end_date=""
     var oTable = $('#users-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url: "{{route('get_state_wise')}}",
                data: function(d) {
                  return $.extend({}, d, {
                    brand_name: brand_name,
                    start_date:start_date,
                    end_date:end_date,
                 });
               }
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
      $('#select_brand').on('change',function(){
        var dateRangePicker = $('#date-range').data('daterangepicker');
        var startDate = dateRangePicker.startDate.format('YYYY-MM-DD');
        var endDate = dateRangePicker.endDate.format('YYYY-MM-DD');
        brand_name=$(this).val();
        start_date=startDate;
        end_date=endDate;
          $.post("{{route('dashboard')}}",{brand:$(this).val(),start:startDate,end:endDate},function(result){
              if(result){
                 $.each(result,function(i,v){
                    $('.'+i).text(v);
                 })
              }
          });
          oTable.ajax.reload();
      });
      $('#date-range').daterangepicker({
        startDate: moment().startOf('year'),
        endDate: moment().endOf('year'), 
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')]
        },
        opens: 'left',
        locale: {
            format: 'YYYY-MM-DD'
        }
    });
      $('#date-range').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
        brand_name=$('#select_brand').val();
        start_date=startDate;
        end_date=endDate;
        $.ajax({
            url: "{{route('dashboard')}}",
            method: 'Post',
            data: {
                start: startDate,
                end: endDate,
                brand:$('#select_brand').val(),
            },
            success: function(result) {
                $.each(result,function(i,v){
                  $('.'+i).text(v);
                });
            }
        });
         oTable.ajax.reload();
      });
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
    var map = L.map('map').setView([37.8, -96], 4);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var stateData = states;  // Original state data

    $.getJSON('{{url("/")}}/us-states.json', function(geojsonData) {
        geojsonData.features.forEach(function(feature) {
            var stateName = feature.properties.name;
            var stateValue = stateData.find(item => item.name === stateName)?.metric;
            feature.properties.value = stateValue || 0;
        });

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.value),
                weight: 1,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        function getColor(value) {
            return value > 100 ? '#800026' :
                   value > 50  ? '#BD0026' :
                   value > 25  ? '#E31A1C' :
                   value > 10  ? '#FC4E2A' :
                   value > 5   ? '#FD8D3C' :
                   value > 0   ? '#FEB24C' :
                                 '#FFEDA0';
        }

        function onEachFeature(feature, layer) {
            if (feature.properties && feature.properties.name) {
                layer.bindPopup("<strong>" + feature.properties.name + "</strong><br>Value: " + feature.properties.value);
            }
        }

        function updateMapData(stateData) {
            // Re-render the map with the updated stateData
            geojsonData.features.forEach(function(feature) {
                var stateName = feature.properties.name;
                var stateValue = stateData.find(item => item.name === stateName)?.metric;
                feature.properties.value = stateValue || 0;
            });

            // Re-render the geoJSON with the updated values
            map.eachLayer(function(layer) {
                if (layer instanceof L.GeoJSON) {
                    map.removeLayer(layer);  // Remove previous GeoJSON layer
                }
            });

            L.geoJSON(geojsonData, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(map);
        }

        // Initial rendering of the map
        L.geoJSON(geojsonData, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);
        $('#select_brand').on('change', function() {
            $.get("{{route('get_map_data')}}",{brand_name:brand_name,start_date:start_date,end_date:end_date},function(result){
                updateMapData(result);
            }); 
        });
        $('#date-range').on('apply.daterangepicker', function(ev, picker) {
              $.get("{{route('get_map_data')}}",{brand_name:brand_name,start_date:start_date,end_date:end_date},function(result){
                updateMapData(result);
            }); 
        });
    });
</script>

@endsection
