<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="main-container">
        <h1>LOGIN</h1>
        <form id="loginForm">
            <div class="login-container">
                <label for="">
                    <span>Username</span>
                    <input type="text" name="username" placeholder="Masukkan Username...">
                </label>
                <label for="">
                    <span>Password</span>
                    <input type="password" name="password" placeholder="Masukkan Password...">
                </label>
            </div>
            <button type="submit">LOGIN</button>
        </form>
        <button>
            <a href="/register">
                REGISTER
            </a>
        </button>
    </div>

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "logina.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            window.location.replace(data.redirect);
                        } else {
                            swal('Oops!', data.message, 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>