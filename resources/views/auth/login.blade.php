<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login Page</title>
    @include('partials._stylesheet')
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-7 bg-light">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Leave Application System</h1>
                                    </div>
                                    @include('partials._notifications')
                                    @include('partials._validation')


                                    <form method="POST" class="user" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="email" type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required placeholder="Enter Email...">

                                        </div>
                                        <div class="form-group">
                                            <input id="password" type="password" class="form-control" name="password"
                                                required placeholder="Enter Password...">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5 d-none d-lg-block" style="margin:auto;">
                                <img src="{{ asset('assets/png/logo.png')}}"
                                    style="width: 300px;display: block;margin-left: auto;margin-right: auto;">
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._script')
</body>

</html>
