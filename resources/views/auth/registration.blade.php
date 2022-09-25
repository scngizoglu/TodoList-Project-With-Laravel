<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Authentication</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div style="width:100%; height:720px;  padding-top:150px; padding-left:40%;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:20px">
                <h4 style="margin-left:70px">Registration</h4>
                <hr>
                <form action="{{route('register-user')}}" method="post">
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter Full Name" name="name" value="{{old('name')}}">
                        <span class="text-danger">@error('name'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" placeholder="Enter Email" name="email" value="{{old('email')}}">
                        <span class="text-danger">@error('email'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>  
                        <input type="text" class="form-control" placeholder="Enter Password" name="password" value="{{old('name')}}">
                        <span class="text-danger">@error('password'){{$message}}@enderror</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Register</button>
                    </div>
                    <br>
                    <a href="login">Already Registered!! Login Here.</a>
                </form>
            </div>
        </div>
    </div>
    </div>


</body>
</html>