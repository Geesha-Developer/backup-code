<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Login</title>
    <!-- Add Bootstrap 4 CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/account.css') }}">
</head>
<style>
    .alert-danger {
    color: #ffffff;
    background-color: rgba(238, 37, 88, 0.8);
    padding-top: .9rem;
    padding-bottom: .9rem;
}
.copyright {
        font-size: 17px;
        margin-top: 42px;
        color:#fff;

    }
    /* login button hover start */
    .nav .fas{
    margin-right: 10px;
}
.nav .fa{
    margin-right: 10px;  
}
.nav li a {
    background: #1D2531;
    color: #fff;
    padding: 10px 20px;
    margin: 0px 10px;
    border-radius: 28px;
    text-decoration: none;
    font-size: 18px;
    border: 2px solid #fff;
}
.nav li a:hover {
    background: #62830b !important;
}
.nav{
    margin-top: 40px;
}
/* login button hover end */
</style>
<body class="vertical-layout vertical-menu-modern" data-open="click" data-menu="vertical-menu-modern" data-col=""
    data-framework="laravel" style="background-image: url('{{ asset('backg.jpg') }}'); background-repeat: no-repeat; background-size: cover; width:100%;height: 100vh;                  ">
    <div class="container">
            <div class="row d-flex justify-content-end">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('login') }}"><i class="fa fa-truck text-white"></i>Broker</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('SuperAdminLogin') }}"><i class="fas fa-user-alt text-white"></i>Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    <scetion class="account-login">
        <div class="container mt-5">
            <div class="row ">
                <div class="col-md-6 offset-md-3">
                    <div class="login-form">
                        <div class="card-body" style="margin-top: 11%;">
                           
                            <div class="logo text-center">
                            <div class="login-heading" style="font-size: 27px; font-weight: 700; color: #fff;">Accounts Login</div>
                              <img src="{{ asset('Cargo-icon.png') }}" alt="" id="login-logo" style="width:33%;">
                                @if(session('success'))
                                <div class="alert alert-success" id="successMessage">
                                    {{ session('success') }}
                                </div>
                                @endif
                                @if(session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    <script>
                                        alert("{{ session('error') }}");
                                    </script>
                                    {{ session('error') }}
                                </div>
                                @endif
                            </div>
                            @if(\Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="alert-body">
                                    {{ \Session::get('success') }}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            {{ \Session::forget('success') }}
                            @if(\Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="alert-body">
                                    {{ \Session::get('error') }}
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form method="post" action="{{ route('account.login.auth') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="border: unset; background: unset;" for="email" class="col-md-4 col-form-label text-md-end">
                                            <img alt="" id="profile"><i class="fa fa-user text-white"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                                    @if ($errors->has('email'))
                                        <span class="help-block font-red-mint">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group mb-3">
                                    <i id="togglePassword" class="fa fa-eye" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <div class="input-group-append">
                                            <span class="input-group-text cursor-pointer" style="border: unset; background: unset;" id="basic-addon2">
                                                <i class="fa fa-lock text-white"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-merge" placeholder="Password" id="password" name="password" tabindex="2" />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="p-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                value="{{ old('remember') ? 'checked' : '' }}">

                                            <label class="form-check-label text-white" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- <div class="p-2 ">
                                        <a class="btn btn-link" href="{{ route('password.request') }}" style="font-weight: 400;color: #007bff;text-decoration: none;font-size: 1rem;">
                                        Forgot Your Password
                                        </a>
                                    </div> -->
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block font-red-mint">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                <button type="submit" class="btn btn-primary" style="background: #1D2531;" tabindex="4">Login</button>
                            </form>

    @if (session('error'))
        <div id="error-popup" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const passwordToggle = document.getElementById('togglePassword');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            passwordToggle.classList.toggle('fa-eye-slash');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const errorPopup = document.getElementById('error-popup');
            if (errorPopup) {
                setTimeout(function() {
                    errorPopup.style.display = 'none';
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center copyright">
    <?php
 $date =  date('Y');
?>
    &#169;Copyright <?php echo $date ?> by <a style="color: #a6ce3a;" href="https://geeshasolutions.com/">Geesha Solutions PVT LTD</a>

</div>
        </section>

        <!-- Add Bootstrap 4 JS dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleIcon = document.getElementById("togglePassword");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

@if(session('success'))
    <script>alert('Login successful!');</script>
@endif

<!-- Your other HTML content here -->

</body>

</html>