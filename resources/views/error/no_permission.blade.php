<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oops...something went wrong!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
</head>

<body class="bg-dark text-white pt-5">
    <div class="container pt-5">
        <div class="row pt-5">
            <div class="col-lg-2 text-center offset-lg-2">
                <h1><i class="fa fa-exclamation-triangle fa-3x"></i><br />403</h1>
            </div>
            <div class="col-lg-8 text-xl-left text-center">
                <h1 style="font-size:4vw;">Forbidden / Access Denied</h1>
                <p style="font-size:2vw;">Sorry, but it seems like you don't have permission</br> to access this
                    page.</p>
                <a class=" btn btn-danger" href="{{ (Auth::user()->role_id == 1)? route('admin.index') : route('user.index') }}">Go to Homepage</a>
            </div>
        </div>
    </div>
</body>

</html>
