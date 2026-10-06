<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz Dashboard - Quiz List</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      .button-group {
          display: inline-block;
      }

      .button-group form {
          display: inline-block;
      }

    </style>
    <!-- inject:css-->

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/bootstrap/bootstrap.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/daterangepicker.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/fontawesome.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/footable.standalone.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/fullcalendar@5.2.0.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/jquery-jvectormap-2.0.5.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/jquery.mCustomScrollbar.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/leaflet.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/line-awesome.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/MarkerCluster.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/MarkerCluster.Default.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/select2.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/slick.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/star-rating-svg.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/trumbowyg.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/vendor_assets/css/wickedpicker.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/style.css')}}">

    {{-- <link href="{{ asset('assets/vendor_assets/simple-datatables/style.css')}}" rel="stylesheet"> --}}

    {{-- <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet"> --}}

    <!-- endinject -->

    <link href="{{ asset('img/american-express.png')}}" rel="icon">

    <style>

      .loding_of_id:after {
            display: block;
            width: 1.5rem;
            height: 1.5rem;
            background: transparent;
            border: 3px solid #6861CE;
            border-bottom-color: transparent;
            border-radius: 50%;
            animation: 1s spin linear infinite; }

        .loader-lg, .loding_of_id-lg:after {
        width: 2rem;
        height: 2rem;
        border-width: 5px; }

        .loader-sm, .loding_of_id-sm:after {
        width: 1rem;
        height: 1rem;
        border-width: 2px; }

        .loding_of_id {
        position: relative;
        color: transparent !important; }
        .loding_of_id > * {
            opacity: 0.2 !important; }
        .loding_of_id:after {
            position: absolute;
            top: calc(50% - 1.5rem/2);
            left: calc(50% - 1.5rem/2);
            content: ''; }

        .loding_of_id-lg:after {
        top: calc(50% - 2rem/2);
        left: calc(50% - 2rem/2); }

        .loding_of_id-sm:after {
        top: calc(50% - 1rem/2);
        left: calc(50% - 1rem/2); }
    </style>
</head>



<style>
  .table-bordered th, .table-bordered tr:hover{
    background: #f1f2f675 !important;
  }
  .table-bordered th, .table-bordered td{
    border: 1px solid #f1f2f6;
    border-bottom: 1px solid #f1f2f6 !important;
  }
  .itemsContainer {
      background:red;
      float:left;
      position:relative
  }

  .itemsContainer:hover .play{display:block;}
  .play{
    position : absolute;
      display:none;
      top:20%;
      width:40px;
      margin:0 auto; left:0px;
      right:0px;
      z-index:100;
      font-size: 30px;
      color: #ff3333;
      cursor: pointer;

  }


</style>
<body class="layout-light side-menu overlayScroll">
    <div class="mobile-author-actions"></div>
    @include('admin.navbar')
    <main class="main-content">
        <div class="contents">
          @include('admin.sidebar')
            <div class="container-fluid">
                <div class="social-dash-wrap">
                    <div class="row">
                        <div class="col-lg-12">
                          <div class="container">
                            <div class="breadcrumb-main">
                              <ul class="atbd-breadcrumb nav">
                                <li class="atbd-breadcrumb__item">
                                    <a href="{{url('Quiz/Quizs')}}">
                                      <span class="la la-home"></span>
                                    </a>
                                    <span class="breadcrumb__seperator">
                                      <span class="la la-slash"></span>
                                  </span>
                                </li>
                                <li class="atbd-breadcrumb__item">
                                    <a href="{{url('Quiz/Quizs')}}">
                                        Home
                                    </a>
                                    <span class="breadcrumb__seperator">
                                        <span class="la la-slash"></span>
                                    </span>
                                </li>
                                <li class="atbd-breadcrumb__item">
                                    <span>Quiz List</span>
                                </li>
                              </ul>
                              <div class="action-btn">
                                <a href="{{url('Quiz/add_Quizs')}}" class="btn btn-sm btn-primary btn-add">
                                  <i class="la la-plus"></i> Add New Quiz</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-30">
                      @if(session()->get('message'))
                        <div id="demo" class="alert-big alert alert-success  alert-dismissible fade show " role="alert">
                          <div class="alert-content">
                              <h6 class="alert-heading">Success !....</h6>
                              <p>{{session()->get('message')}}</p>
                              <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                              </button>
                          </div>
                        </div>
                        <br>
                      @endif
                      @if(session()->get('error'))
                        <div id="demo" class="alert-big alert alert-danger  alert-dismissible fade show " role="alert">
                          <div class="alert-content">
                              <h6 class="alert-heading">Warning !....</h6>
                              <p>{{session()->get('error')}}</p>
                              <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                              </button>
                          </div>
                        </div>
                        <br>
                      @endif

                      <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                          @if (session('import_errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <div class="alert-content">
                                <h6 class="alert-heading">Success !....</h6>
                                <ul>
                                  @foreach (session('import_errors') as $error)
                                    <li><strong>{{ $error }}</strong></li>
                                  @endforeach
                                </ul>
                                <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                              </div>
                            </div>
                          @endif
                          <br>
                        </div>
                      </div>
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12 grid-margin stretch-card">
                            @if (session('success_message'))
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="alert-content">
                                  <h6 class="alert-heading">Success !....</h6>
                                  <ul>
                                      <li><strong>{{session('success_message')}}</strong></li>
                                  </ul>
                                  <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                  </button>
                                </div>
                              </div>
                              <br>
                            @endif
                          </div>
                        </div>
                      </div>


                      @if ($errors->any())
                        @foreach ($errors->all() as $error)
                          <div id="demo" class="alert-big alert alert-danger  alert-dismissible fade show " role="alert">
                            <div class="alert-content">
                                <h6 class="alert-heading">Warning !....</h6>
                                <p>{{$error}}</p>
                                <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>
                          </div>
                        @endforeach
                      @endif
                      <div class="card">
                          <div class="card-header color-dark fw-500">
                              Quiz List

                              <div class="pull-right">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                                  Import
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Import A Quiz Data File</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body ">
                                        <form id="fileUploadForm" action="{{ route('users.import')}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          <div class="row">
                                            <div class="col-md-12">
                                              <input type="hidden" name="set_type" value="2">
                                              <input type="file" name="file" class="form-control">
                                            </div>
                                            <div class="col-md-12">
                                              <br>
                                              <button type="submit" class="btn btn-success btn-sm" id="import">Upload</button>
                                            </div>
                                          </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <style>
                            .btn_status
                            {
                              font-size: .70rem;
                              font-weight: 500;
                              letter-spacing: 1px;
                              padding: 5px 10px;
                              border-radius: 0.25rem;
                              text-transform: uppercase;
                              box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
                            }
                          </style>
                          <div class="card-body">
                              <div class="userDatatable global-shadow border-0 bg-white w-100">
                                  <div class="table-responsive">
                                      <table id="set_2" class="table mb-0 table-bordered">
                                          <thead>
                                              <tr class="userDatatable-header">
                                                  <th>
                                                    <div class="d-flex align-items-center">
                                                        <div class="custom-checkbox  check-all">
                                                            <input class="checkbox" type="checkbox" name="checkbox" id="check-3">
                                                            <label for="check-3"></label>
                                                        </div>
                                                    </div>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title">Quiz ID</span>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title">Quiz Name</span>
                                                  </th>
                                                  <th>
                                                    <span class="userDatatable-title">Quiz content</span>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title">Quiz Image</span>
                                                  </th>
                                                  <th>
                                                    <span class="userDatatable-title">Category</span>
                                                  </th>
                                                  <th>
                                                    <span class="userDatatable-title">Sub Category Name</span>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title">Created At</span>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title">Status</span>
                                                  </th>
                                                  <th>
                                                      <span class="userDatatable-title float-left">Action</span>
                                                  </th>
                                                  <th>
                                                    <span class="userDatatable-title float-left">Status Update</span>
                                                  </th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            {{-- @foreach($questions as $Quiz)
                                              <tr>
                                                  <td>
                                                    <div class="d-flex">
                                                        <div class="userDatatable__imgWrapper d-flex align-items-center">
                                                            <div class="checkbox-group-wrapper">
                                                                <div class="checkbox-group d-flex">
                                                                    <div class="checkbox-theme-default custom-checkbox checkbox-group__single d-flex">
                                                                        <input class="checkbox" type="checkbox" id="check-grp-{{$Quiz->id}}">
                                                                        <label for="check-grp-{{$Quiz->id}}"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </td>
                                                  <td>
                                                    <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                                      <a href="#" class="text-dark fw-500">
                                                          <h6>{{$Quiz->question_name}}</h6>
                                                      </a>
                                                    </div>
                                                  </td>
                                                  <td>
                                                    @if(($Quiz->question_format_type == 3) || ($Quiz->question_format_type == 4))
                                                    <div class="app userDatatable-inline-title" style="max-width: 100px;text-overflow:hidden;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">
                                                      <a href="#" class="text-dark fw-500">
                                                          <h6><center><img src="{{asset($Quiz->question_content)}}"  style="height:50px; width:auto;border-radius:70%;"></center></h6>
                                                      </a>
                                                    </div>
                                                    @else
                                                    <div class="app userDatatable-inline-title">
                                                      <a href="#" class="text-dark fw-500">
                                                          <center><h6>Nil</h6></center>
                                                      </a>
                                                    </div>
                                                    @endif
                                                  </td>
                                                  <td>
                                                      <div class="userDatatable-content">
                                                        @if($Quiz->quiz_image == null)
                                                          <center><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdoCQ7-yS62tALBS9_FY5pExwg8Lvvsie6Iml51YO_JQ&s" style="height:50px; width:auto;border-radius:70%;"></center>
                                                        @elseif($Quiz->image_type == 1)
                                                          <center><img src="{{asset($Quiz->quiz_image)}}"  style="height:50px; width:auto;border-radius:70%;"></center>
                                                        @else
                                                          <center><img src="{{$Quiz->quiz_image}}" style="height:60px; width:70px;border-radius:50%;"></center>
                                                        @endif
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <div class="userDatatable-content">
                                                      {{$Quiz->category->category_name ??'nil'}}
                                                    </div>
                                                  </td>
                                                  <td>
                                                    <div class="userDatatable-content">
                                                      {{$Quiz->subcategory->sub_category_name ??'nil'}}
                                                    </div>
                                                  </td>
                                                  <td>
                                                      <div class="userDatatable-content">
                                                         {{date('d-m-Y', strtotime($Quiz->created_at))}}
                                                      </div>
                                                  </td>
                                                  <td>
                                                      <div class="userDatatable-content d-inline-block">
                                                        @if($Quiz->is_active == '0')
                                                          <span class="bg-opacity-success  color-success rounded-pill userDatatable-content-status active">active</span>
                                                        @else
                                                        <span class="bg-opacity-warning  color-warning rounded-pill userDatatable-content-status active">deactivete</span>
                                                        @endif
                                                      </div>
                                                  </td>
                                                  <td>
                                                    <div class="dropdown dropdown-click" style="padding-left: 25px;">
                                                      <button class="btn-link border-0 bg-transparent p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <span class="text-dark" data-feather="more-vertical"></span>
                                                      </button>
                                                      <div class="dropdown-default dropdown-menu bg-dark">
                                                        <div class="dropdown-item" style="padding-left:55px !important;">
                                                          <form action={{url("Quiz/edit_Quiz/".$Quiz->id)}} method="POST">
                                                            {{csrf_field()}}
                                                            <button type="submit" name="submit" class="btn btn-icon btn-circle btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit Quiz"><span data-feather="edit"></span></button>
                                                          </form>
                                                        </div>
                                                        <div class="dropdown-item" style="padding-left:55px !important;">
                                                          <form action={{url("Quiz/delete_Quiz/".$Quiz->id)}} method="POST">
                                                            {{csrf_field()}}
                                                            <button  type="submit" class="btn btn-icon btn-circle btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?');" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Quiz"><span data-feather="trash-2"></span></button>
                                                          </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </td>
                                                  <td>
                                                    <form action="{{url('Quiz/Quiz_status_update')}}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="Quiz_id" value="{{$Quiz->id}}">
                                                      @if($Quiz->is_active == '0')
                                                          <input type="hidden" name="status" value="0">
                                                          <button type="submit" data-toggle="tooltip"  data-original-title="Enable" id="enable" name="enable" title="" class="btn_status btn-success enable">
                                                              <i class="mdi mdi-check"></i>Enabled
                                                          </button>
                                                      @else
                                                          <input type="hidden" name="status" value="1">
                                                          <button type="submit" data-toggle="tooltip" data-original-title="Disable" id="disable" title="" name="disable" class="btn_status btn-success" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                                            <i class="mdi mdi-discord"></i>Disabled
                                                          </button>
                                                      @endif
                                                    </form>
                                                  </td>
                                              </tr>
                                            @endforeach --}}
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>


                </div>
            </div>
        </div>

        <footer class="footer-wrQuizer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <div id="overlayer">
        <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </span>
    </div>
    <div class="overlay-dark-sidebar"></div>

    {{--  --}}
    <!-- inject:js-->
    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-ui.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/bootstrap/popper.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/moment/moment.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/accordion.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/autoComplete.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/Chart.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/charts.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/daterangepicker.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/drawer.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/dynamicBadge.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/dynamicCheckbox.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/feather.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/footable.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/fullcalendar@5.2.0.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/google-chart.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.countdown.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.filterizr.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.mCustomScrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.peity.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/jquery.star-rating-svg.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/leaflet.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/leaflet.markercluster.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/loader.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/message.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/moment.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/muuri.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/notification.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/popover.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/slick.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/trumbowyg.min.js')}}"></script>
    <script src="{{ asset('assets/vendor_assets/js/wickedpicker.min.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/drag-drop.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/footable.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/full-calendar.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/googlemap-init.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/icon-loader.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/jvectormap-init.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/leaflet-init.js')}}"></script>
    <script src="{{ asset('assets/theme_assets/js/main.js')}}"></script>
    {{-- <script src="{{ asset('assets/vendor_assets/simple-datatables/simple-datatables.js')}}"></script> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />

    <style>
        .dataTables_wrapper .dt-buttons {
            margin-bottom: 10px;
          }

          .dt-buttons .dt-button {
            display: inline-block;
            margin-right: 5px;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #f5f5f5;
            border-color: #ccc;
            color: #333;
          }

          .dt-buttons .dt-button:hover,
          .dt-buttons .dt-button:focus {
            color: #333;
            background-color: #e6e6e6;
            border-color: #adadad;
          }

          .dt-buttons .dt-button.active,
          .dt-buttons .dt-button:active {
            background-color: #e6e6e6;
            border-color: #adadad;
            color: #333;
          }

          .dt-buttons .dt-button.disabled,
          .dt-buttons .dt-button[disabled],
          .dt-buttons .dt-button[disabled]:hover,
          .dt-buttons .dt-button[disabled]:focus,
          .dt-buttons .dt-button[disabled]:active {
            background-color: #f5f5f5;
            border-color: #ccc;
            color: #777;
            cursor: not-allowed;
          }

          .dt-buttons .dt-button:first-child {
            margin-left: 0;
          }

      /*      Datatable     */
      table.dataTable {
          clear: both;
          margin-top: 15px !important;
          margin-bottom: 15px !important;
          max-width: none !important;
          border-collapse: separate !important; }
      table.dataTable td, table.dataTable th {
          -webkit-box-sizing: content-box;
          box-sizing: content-box; }
      table.dataTable td.dataTables_empty, table.dataTable th.dataTables_empty {
          text-align: center; }
      table.dataTable.nowrap th, table.dataTable.nowrap td {
          white-space: nowrap; }

      div.dataTables_wrapper div.dataTables_length label {
      font-weight: normal;
      text-align: left;
      white-space: nowrap; }
      div.dataTables_wrapper div.dataTables_length select {
      width: 75px;
      display: inline-block; }
      div.dataTables_wrapper div.dataTables_filter {
      text-align: right; }
      div.dataTables_wrapper div.dataTables_filter label {
          font-weight: normal;
          white-space: nowrap;
          text-align: left; }
      div.dataTables_wrapper div.dataTables_filter input {
          margin-left: 0.5em;
          display: inline-block;
          width: auto; }
      div.dataTables_wrapper div.dataTables_info {
          padding-top: 0.85em;
          white-space: nowrap;
          display: inline-block;
          margin-bottom: 26px;
          margin-right: 10px;
      }
      .dataTables_wrapper .dataTables_paginate {
          margin: 0 !important;
          white-space: nowrap !important;
          text-align: right !important;
          display: inline-block;
          float: right;
          position: absolute;
          right: 62px;
      }
      div.dataTables_wrapper div.dataTables_paginate ul.pagination {
          margin: 2px 0 !important;
          white-space: nowrap !important;
          justify-content: flex-end !important;
        }
      div.dataTables_wrapper div.dataTables_processing {
          position: absolute;
          top: 50%;
          left: 50%;
          width: 200px;
          margin-left: -100px;
          margin-top: -26px;
          text-align: center;
          padding: 1em 0;
          background:#113c68;
          border: 2px solid #ffffff;
          color: #ffffff;
      }

      table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting, table.dataTable thead > tr > td.sorting_asc, table.dataTable thead > tr > td.sorting_desc, table.dataTable thead > tr > td.sorting {
      padding-right: 30px; }
      table.dataTable thead > tr > th:active, table.dataTable thead > tr > td:active {
      outline: none; }
      table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
      cursor: pointer;
      position: relative; }
      table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
      position: absolute;
      bottom: 0.9em;
      display: block;
      opacity: 0.5; }
      table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before {
      right: 1em;
      content: "\2191";
      font-size: 15px; }
      table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
      right: 0.5em;
      content: "\2193";
      font-size: 15px; }
      table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:after {
      opacity: 1; }
      table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
      opacity: 0; }

      div.dataTables_scrollHead table.dataTable {
      margin-bottom: 0 !important; }
      div.dataTables_scrollBody table {
      border-top: none;
      margin-top: 0 !important;
      margin-bottom: 0 !important; }
      div.dataTables_scrollBody table thead .sorting:after, div.dataTables_scrollBody table thead .sorting_asc:after, div.dataTables_scrollBody table thead .sorting_desc:after {
          display: none; }
      div.dataTables_scrollBody table tbody tr:first-child th, div.dataTables_scrollBody table tbody tr:first-child td {
          border-top: none; }
      div.dataTables_scrollFoot > .dataTables_scrollFootInner {
      box-sizing: content-box; }
      div.dataTables_scrollFoot > .dataTables_scrollFootInner > table {
          margin-top: 0 !important;
          border-top: none; }

      @media screen and (max-width: 767px) {
      div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
          text-align: center;
          margin-top: 11px;
          margin-bottom: 26px;
      }
      div.dataTables_wrapper div div.dataTables_paginate ul.pagination {
          flex-wrap: wrap !important;
          justify-content: center !important; }
          div.dataTables_wrapper div div.dataTables_paginate ul.pagination li {
          margin-bottom: 10px !important; }
          div.dataTables_wrapper div div.dataTables_paginate ul.pagination li a {
              font-size: 11px !important; } }
      table.dataTable.table-sm > thead > tr > th {
      padding-right: 20px; }
      table.dataTable.table-sm .sorting:before, table.dataTable.table-sm .sorting_asc:before, table.dataTable.table-sm .sorting_desc:before {
      top: 5px;
      right: 0.85em; }
      table.dataTable.table-sm .sorting:after, table.dataTable.table-sm .sorting_asc:after, table.dataTable.table-sm .sorting_desc:after {
      top: 5px; }
      table.table-bordered.dataTable th, table.table-bordered.dataTable td {
      border-left-width: 0; }
      table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child {
      border-right-width: 0; }
      table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
      border-bottom-width: 0; }

      div.dataTables_scrollHead table.table-bordered {
      border-bottom-width: 0; }
      div.table-responsive > div.dataTables_wrapper > div.row {
      margin: 0; }
      div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:first-child, div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:last-child {
          padding-left: 0;
          padding-right: 0; }
    </style>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#set_2').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                order: [[1, 'desc']],
                scrollX: true,
                ajax: "{{ url('Quiz/Quizs') }}",
                columns: [
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                    { data: 'id', name: 'id' },
                    { data: 'question_name', name: 'question_name' },
                    { data: 'question_content', name: 'question_content' },
                    { data: 'quiz_image', name: 'quiz_image', orderable: false, searchable: false },
                    { data: 'category_id', name: 'category_id' },
                    { data: 'sub_category_id', name: 'sub_category_id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                    { data: 'status_update', name: 'status_update', orderable: false, searchable: false },
                ],
                dom: 'Bflrtip',
                buttons: ['copy', 'excel', 'csv', 'pdf'],
            });
        });
    </script>

    <script>
        const myTimeout = setTimeout(myGreeting, 3000);
        function myGreeting() {
            $('#demo').hide();
          }
        
        $('#colse_btn').on('click',function()
        {
          $('#drawer').hide();
        });
    </script>
</body>

</html>
