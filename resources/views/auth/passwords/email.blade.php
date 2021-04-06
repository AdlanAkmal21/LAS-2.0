<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Forgot Page</title>
    @include('partials._stylesheet')
</head>


<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-header text-dark">{{ __('Reset Password') }}</div>
                    <div class="card-body">
                        @include('partials._validation')
                        @include('partials._notifications')

                        @if (!(Session::has('message')))
                        <form method="POST" action="{{ route('forgot.post_email') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col">
                                    <div class="form-row">
                                        <label for="email" class="text-dark col-sm-2">Email:</label>
                                        <input id="email" type="email" placeholder="Enter your email for password reset." class="form-control col-sm-10" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Send Email') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials._script')
</body>

</html>
