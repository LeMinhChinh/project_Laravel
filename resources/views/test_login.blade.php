<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>   
    <div class="container">    
        <div class="row">
            <div class="col-8 col-md-8 offset-md-2 mt-3">
                <h2 class="text-center" style="color:red;text-align:center">Login</h2>
                <form action="{{ route('user.login') }}" class="form-group border p-3 mt-3" method="POST">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username"><br>
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password"><br>
                    <button type="submit" class="btn btn-primary" name="btnInsert" style="margin-left:290px"> Submit </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>