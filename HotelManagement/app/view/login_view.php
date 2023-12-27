<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card">
                <div class="card-title text-center border-bottomr">
                    <h2 class="p-3">Login</h2>
                </div>
                <div class="card-body">
                    <form id="loginForm">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control my-3 py-2" required>
                        <br>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control my-3 py-2" required>
                        <br>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="result"></div>

<script src="assets/js/script.js"></script>
</body>
</html>
<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            var username = $('#username').val();
            var password = $('#password').val();

            authenticateUser(username, password);
        });
    });
</script>