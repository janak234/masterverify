@extends('admin.layouts.app')
@section('content')
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
                      </div>
                      <style>
                        .badged i{height: 1.45rem;
  width: 1.45rem;
  font-size: 1.45rem;
  margin-right: 1.1rem;
  -webkit-flex-shrink: 0;
  -ms-flex-negative: 0;
  flex-shrink: 0;}
.badgex{margin-right: 5px;}
  .badgex .feather, [data-feather] {
	height: 2rem;
	width: 2rem;
	display: inline-block;
}
                      </style>
                      <div class="card-body">
                        <div class="row gy-3">
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badgex">
                                <i data-feather="layers"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">50</h5>
                                <small>Total Products</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0">3</h5>
                                <small>Products Verified</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0">500</h5>
                                <small> Codes Generated</small>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
     <!-- BEGIN: Page JS-->

     <!-- END: Page JS-->
@endsection
