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

    <title>Forgot Password - Leave Application System (LAS)</title>
  </head>
  <body>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{ asset('assets/login/images/undraw_remotely_-2-j6y.svg') }}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="my-4">
              {{-- <h3>Sign In</h3> --}}
              <h3>Leave Application System</h3>
              {{-- <p class="mb-4">Leave Application System</p> --}}
              <p class="mb-4">Forgot Password</p>
                @include('partials._notifications')
                @include('partials._validation')
            </div>

            @if (!(Session::has('message')))

            <form method="POST" action="{{ route('forgot.post_email') }}">
                @csrf
              <div class="form-group mb-4 ">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
              </div>

              <input type="submit" value="Send Email" class="btn btn-block btn-primary">

            </form>

            @endif

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
