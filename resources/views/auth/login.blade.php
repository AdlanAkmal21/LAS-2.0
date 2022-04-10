<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/login/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/login/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/login/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/login/css/style.css') }}">

    <title>Login Page - Leave Application System (LAS)</title>
  </head>
  <body>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('assets/login/images/undraw_in_the_office_re_jtgc.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="my-4">
                <img src="{{ asset('assets/png/logo.png')}}" style="width: 200px;display: block;margin-left: auto;margin-right: auto;margin-bottom: 40px;">
                <h3>Leave Application System</h3>
                <p class="mb-4">Sign In</p>
                {{-- <h3>Sign In</h3> --}}
              {{-- <p class="mb-4">Leave Application System</p> --}}
                @include('partials._notifications')
                @include('partials._validation')
            </div>
            <form method="POST" class="user" action="{{ route('login') }}">
                @csrf
              <div class="form-group first">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>

              </div>

              <div class="d-flex mb-4 align-items-center">
                {{-- <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label> --}}
                <span class="ml-auto mr-auto"><a href="{{ route('forgot.get_email') }}" class="forgot-pass">Forgot Password</a></span>
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

            </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>


    <script src="{{ asset('assets/login/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/main.js') }}"></script>
  </body>
</html>
