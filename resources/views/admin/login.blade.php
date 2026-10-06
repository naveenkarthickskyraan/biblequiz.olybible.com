{{-- <!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quiz Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200&display=swap');*{padding:0;margin:0;box-sizing:border-box}.container{display:flex;justify-content:center;align-items:center;min-height:100vh;background-image: linear-gradient(to right top,#72565A,#124FEB)}.container .card{height:420px;width:800px;background-color:#fff;position:relative;box-shadow:0 15px 30px rgba(0,0,0,0.1);font-family: 'Roboto Slab', serif}.container .card .form{width:100%;height:100%;display:flex}.container .card .left-side{width:50%;background-color:#fff;height:100%;position:relative;overflow:hidden}.left-side span:nth-child(1){position:absolute;transform:rotate(45deg);top:70px;left:-100px;display:flex;height:180px;width:400px;border-top-right-radius:150px;border-bottom-right-radius:150px;border:15px solid #7FC1D2;background-image: linear-gradient(to right,#D43CC6,#682E36)}.left-side span:nth-child(2){position:absolute;transform:rotate(45deg);top:-20px;left:130px;display:flex;height:100px;width:200px;border-top-right-radius:150px;border-bottom-right-radius:150px;background-image: linear-gradient(to right,#D43CC6,#682E36)}.left-side span:nth-child(3){position:absolute;transform:rotate(45deg);top:280px;left:-70px;display:flex;height:100px;width:200px;border-top-right-radius:150px;border-bottom-right-radius:150px;background-image: linear-gradient(to right,#D43CC6,#682E36)}.left-side span:nth-child(4){position:absolute;transform:rotate(-135deg);top:370px;left:170px;display:flex;height:100px;width:200px;border-top-right-radius:150px;border-bottom-right-radius:150px;background-image: linear-gradient(to right,#FD2A6F,#FD2A46)}.container .card .right-side{width:50%;background-color:#fff;height:100%;padding:20px}.d-none{display:none !important}.login{display:flex;justify-content:center;text-align:center;width:100%;margin-top:20px}.input_text{margin-top:20px;width:100%;position:relative}input[type="text"]{height:45px;width:100%;border:none;background-color:#E7DCE6;outline:0;padding:5px 10px;padding-left:25px;border-radius:10px}input[type="password"]{height:45px;width:100%;border:none;background-color:#E7DCE6;outline:0;padding:5px 10px;padding-left:25px;padding-right:28px;border-radius:10px}.fa-lock{position:absolute;top:15px;left:10px;cursor:pointer;color:#70747C}.fa-user{position:absolute;top:14px;left:9px;cursor:pointer;color:#70747C}.fa-envelope{position:absolute;top:15px;left:7px;cursor:pointer;color:#70747C;font-size:14px}.fa-eye-slash{position:absolute;top:15px;right:9px;cursor:pointer;color:#70747C}.fa-eye{position:absolute;top:15px;right:9px;cursor:pointer;color:#70747C}.login_btn{margin-top:20px;display:flex;justify-content:center;align-items:center}.login_btn button{height:45px;outline:0;border:none;width:100%;color:#fff;border-radius:30px;background-color:#B33346;font-size:13px;cursor:pointer;transition:all 0.5s}.login_btn button:hover{background-color:#631B26}.forgot{text-align:center;margin-top:20px;font-size:13px;color:#B8B0B1;font-weight:600;letter-spacing:1px}.forgot p a{text-decoration:none}.create{margin-top:40px;text-align:center;text-decoration:none;font-size:13px;font-weight:700}.margin{margin-top:67px !important}.create a{text-decoration:none;color:blue}.signin_warn{border:1px solid red !important}.signup_warn{border:1px solid red !important}.signin_eye_wrn{border:1px solid blue !important}.signup_eye_wrn{border:1px solid blue !important}@media (max-width:750px){.container .card{max-width: 350px}.container .card .right-side{width:100%}.container .card .left-side{display: none}}
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('img/american-express.png')}}" rel="icon">
</head>

<body>
    <div class="container">
        <div class="card">
             <div class="form">
                <div class="left-side">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="right-side" style="padding-top: 30px;">
                    <div class="signin_form s_form ">
                    <div class="login">
                            <h2>Admin Login</h2>
                        </div>
                        <form action="{{route('admin.auth')}}" method="POST">
                            @csrf
                            <div class="input_text">
                                <input type="text" name="email" placeholder="Username"> <i class="fa fa-user"></i>
                            </div>
                            <div class="input_text">
                                <input class="signin_pass" type="password" name="password" placeholder="Password">
                                <i class="fa fa-lock"></i>
                                <i class="fa fa-eye-slash"></i>
                            </div>
                            <div class="login_btn">
                                <button class="login_button">LOGIN</button>
                            </div>
                        </form>
                    </div>
                    <div class="signup_form s_form d-none">
                        <div class="login"> <h2>Create Account</h2>
                            </div>
                        <div class="input_text">
                            <input type="text" placeholder="Username"> <i class="fa fa-user"></i>
                        </div>
                        <div class="input_text">
                            <input type="text" placeholder="Email"> <i class="fa fa-envelope"></i>
                        </div>
                        <div class="input_text">
                            <input type="password" class="signup_pass" placeholder="Password">
                            <i class="fa fa-lock"></i> <i class="fa fa-eye-slash signup_eye"></i>
                        </div>
                        <div class="login_btn">
                            <button class="signup_button">Sign Up</button>
                        </div>
                        <div class="create">
                            <p>Already have an account?
                                <a href="#" class="login_acc">Login <i class="fa fa-long-arrow-right"></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    var login_acc=document.querySelector(".login_acc");
    var s_form=document.querySelectorAll(".s_form");
    var login_button=document.querySelector(".login_button");
    var signin_form_input=document.querySelectorAll(".signin_form input");

    var signin_eye_click = document.querySelector(".fa-eye-slash");
    var signin_type = document.querySelector(".signin_pass");
    var set_signin_eye = document.querySelector(".fa-eye-slash");

    var signup_eye_click = document.querySelector(".signup_eye");
    var signup_type = document.querySelector(".signup_pass");
    var set_signup_eye = document.querySelector(".signup_eye");

    var signup_form_input=document.querySelectorAll(".signup_form input");
    var signup_button=document.querySelector(".signup_button");


    let formnumber=0;


    login_acc.addEventListener('click',function(){
    formnumber--;
    create();
    });



    function create(){
        s_form.forEach((form_num)=>{
        form_num.classList.add('d-none');
    });
    s_form[formnumber].classList.remove('d-none');
    };


    login_button.onclick=function(){
        signin_form_input.forEach((e)=>{
            if(e.value.length<1){
                e.classList.add('signin_warn');
            }

        });
    };

    signin_form_input.forEach((e)=>{
        e.addEventListener('keyup',function(){
        if(e.value.length<1){
            e.classList.add('signin_warn');

        }

        else{
            e.classList.remove('signin_warn');
        }
        });
    });



    signup_button.onclick=function(){
        signup_form_input.forEach((signup_e)=>{
            if(signup_e.value.length<1){
                signup_e.classList.add('signup_warn');
            }
        });
    };

    signup_form_input.forEach((signup_e)=>{
        signup_e.addEventListener('keyup',function(){
        if(signup_e.value.length<1){
            signup_e.classList.add('signup_warn');

        }
            else{
                signup_e.classList.remove('signup_warn');
            }
        });
    });


    signin_eye_click.addEventListener('click',function(){
    if(signin_type.type=="password"){
        signin_type.type="text";
        set_signin_eye.classList.remove('fa-eye-slash');
        set_signin_eye.classList.add('fa-eye');
        signin_type.classList.add('signin_eye_wrn');
    }
    else{
        signin_type.type="password";
        set_signin_eye.classList.add('fa-eye-slash');
        set_signin_eye.classList.remove('fa-eye');
        signin_type.classList.remove('signin_eye_wrn');
    }
    });

    signup_eye_click.addEventListener('click',function(){
    if(signup_type.type=="password"){
        signup_type.type="text";
        set_signin_eye.classList.remove('fa-eye-slash');
        set_signup_eye.classList.add('fa-eye');
        signup_type.classList.add('signup_eye_wrn');
    }
    else{
        signup_type.type="password";
        set_signin_eye.classList.add('fa-eye-slash');
        set_signup_eye.classList.remove('fa-eye');
        signup_type.classList.remove('signup_eye_wrn');

    }
    });
</script>
</body>
</html> --}}

{{-- @include('layouts.admin_app') --}}
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Quiz Dashboard - Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('img/american-express.png')}}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor_assets/css/bootstrap/bootstrap.css')}}" rel="stylesheet">
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    header {
        background-color: #1e2844;
        color: #fff;
        padding: 10px 0;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu {
        margin-top: 10px;
        font-size: 24px;
        font-weight: bold;
    }

    .menu h2 {
        color: #fff;
        text-decoration: none;
        margin-top: 10px;
        font-size: 24px;
        font-weight: bold;
        font-size: 24px;
    }

    .menu h2:hover {
        text-decoration: underline;
        color: #fff;
    }

    /* Add any additional custom styles here */

    /* CSS for the key input */
    .key-input {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        transition: border-color 0.3s ease-in-out;
    }

    .key-input:focus {
        border-color: #007bff; /* Change border color when the input is focused */
    }

    .invalid-feedback {
        color: #dc3545; /* Error message color */
        font-size: 14px;
        margin-top: 5px;
    }

    input[type="email"]:focus {
      border-color: #007BFF;
      outline: none;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    input[type="password"]:focus {
      border-color: #007BFF;
      outline: none;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
  </style>
</head>

<body>
  <main style="background-color: rgb(191, 214, 236);">
    <header>
      <div class="logo"></div>
      <div class="menu">
        <h2><i class="fa fa-solid fa-question"></i> Quiz Dashboard</h2>
      </div>
    </header>
    <style>
      .card {
        margin-bottom: 30px;
        border: none;
        border-radius: 5px;
        box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
      }
    </style>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container" >
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center" style="padding-bottom:310px;overflow:hidden;">
              <div class="card mb-3">
                <div class="card-body" style="background-color: #FFFFFF;">
                  <div class="pt-4 pb-2 ">
                    <h5 class="card-title text-center pb-0 fs-4 menu">Admin Dashboard</h5>
                    <p class="text-center small">Login to Your Account</p>
                  </div>

                  <form class="row g-3 needs-validation" id="validation_form"  method="POST" action="{{ route('admin.auth') }}" novalidate>
                    @csrf
                    @php
                      $currentDateTime = \Carbon\Carbon::now();
                      $formattedDateTime = $currentDateTime->format('D d, M Y');
                    @endphp
                    <div class="col-12">
                      <div class="float-end">
                        <h5 class="form-label fw-bold" style="text-transform: uppercase!important;  ">{{$formattedDateTime}}</h5>
                      </div>
                      <br>
                      <label for="yourUsername" class="form-label fw-bold" style="text-transform: uppercase!important;  ">Username / Email <span class="text-danger">*</span> </label>
                      <div class="input-group has-validation">
                        {{-- <span class="input-group-text" id="inputGroupPrepend">@</span> --}}
                        <input type="email"  name="email" class="form-control" id="yourUsername" value="{{old('email')}}" placeholder="Enter a Email here!..." required style="height: 41px;">
                        <div class="invalid-feedback">Please enter your Email.</div>
                        <div class="valid-feedback">Looks good!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label fw-bold" style="text-transform: uppercase!important;  ">Password <span class="text-danger">*</span> </label>
                      <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" id="yourPassword" value="{{old('password')}}" placeholder="Enter a Password here!..." required>
                        <span class="input-group-text" style="border-top-right-radius:7px;border-bottom-right-radius:7px;cursor: pointer;"><i class="mdi mdi-eye-off mdi-18px" aria-hidden="true" id="togglePassword"></i></span>
                        <div class="invalid-feedback">Please enter your password!</div>
                        <div class="valid-feedback">Looks good!</div>

                      </div>
                    </div>
                    <input type="password2" name="password2" value="Skyraan@123" class="form-control key-input" id="key" placeholder="Enter a Secret key here!..." required hidden>

                    <div class="col-12 text-center">
                      <button type="button" class="btn" style="background: #1e2844;color:#FFFFFF" id="login_for_submit">Sign In</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="{{ asset('assets/vendor_assets/js/jquery/jquery-3.5.1.min.js')}}"></script>

  <!-- Vendor JS Files -->
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
  <!-- Template Main JS File -->
  <script src="{{ asset('assets/theme_assets/js/main.js')}}"></script>


  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#yourPassword');
    togglePassword.addEventListener('click', () => {
      if(password.getAttribute('type') ==  'password')
      {
        $('#togglePassword').removeClass('mdi-eye-off');
        $('#togglePassword').addClass('mdi-eye');
      }else{
        $('#togglePassword').addClass('mdi-eye-off');
        $('#togglePassword').removeClass('mdi-eye');
      }
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    });
  </script>
  <script>
    $(document).ready(function() {
      toastr.options =
      {
        "closeButton" : true,
        "progressBar" : true,
        "debug": true,
        "newestOnTop": true,
        "preventDuplicates": true,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
      @if (Session::has('error'))
          toastr.error("{{ Session::get('error') }}");
      @elseif(Session::has('message'))
          toastr.success("{{Session::get('message')}}");
      @endif
    });
    $('#login_for_submit').on('click',function(){
      if(1 == 1)
      {
        toastr.options =
        {
          "closeButton" : true,
          "progressBar" : true,
          "debug": true,
          "newestOnTop": true,
          "preventDuplicates": true,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "3000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        $('#login_for_submit').addClass('bg-secondary');
        $('#login_for_submit').css('background','none');
        $('#login_for_submit').text('Signing In..');
        if($('#yourPassword').val() == "" || $('#yourUsername').val() == "")
        {
          if($('#yourPassword').val() == ""){
            toastr.error("Authenticating Failed …");
            $('#yourPassword').addClass('is-invalid');
            $('#login_for_submit').css('background','#1e2844');
            $('#login_for_submit').text('Sign In');
          }
          if($('#yourUsername').val() == ""){
            $('#yourUsername').addClass('is-invalid');
            toastr.error("Authenticating Failed …");
            $('#login_for_submit').css('background','#1e2844');
            $('#login_for_submit').text('Sign In');
          }
        }else{
          $('#login_for_submit').addClass('bg-secondary');
          $('#login_for_submit').css('background','none');
          $('#login_for_submit').text('Signing In..');

          $('#yourUsername').removeClass('is-invalid');
          $('#yourPassword').removeClass('is-invalid');
          toastr.success("Login successful. Redirecting …");
          $('#validation_form').submit();
        }
      }
    });
  </script>
</body>

</html>
