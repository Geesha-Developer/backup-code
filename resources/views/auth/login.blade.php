@extends('layouts.app')
@section('content')
<style>
    .alert-danger {
        color: #ffffff;
        background-color: rgba(238, 37, 88, 0.8);
        padding-top: .9rem;
        padding-bottom: .9rem;
        transition: opacity 0.5s ease-out; /* Smooth fade-out transition */
    }
    .alert.alert-danger {
        right: 30px !important;
    width: 90%;
    top: 226px !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card-body p-0" style="margin-top: 11%;">
                <form method="POST" action="{{ route('login') }}" class="login-form" style="padding: 28px;">
                    @csrf
                    <div class="logo text-center">
                        <div class="login-heading" style="font-size: 27px; font-weight: 700; color: #fff;">Agent Login</div>
                        <img src="{{ asset('Cargo-icon.png') }}" alt="" id="login-logo" style="width:33%;"><br>
                        @error('email')
                        <div class="alert alert-danger" role="alert" id="errorMessage">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="border: unset; background:none;">
                                <i class="fa fa-user text-white"></i>
                            </span>
                        </div>
                        <input id="email" type="email" style="background: #FFF;" class="form-control @error('email') is-invalid @enderror" 
                            placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="border: unset; background:none;">
                                <i class="fa fa-lock text-white"></i>
                            </span>
                        </div>
                        <input id="password" type="password" style="background: #FFF;" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <i id="togglePassword" class="fa fa-eye" aria-hidden="true" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

    // Auto-hide error message after 2 seconds
    document.addEventListener('DOMContentLoaded', function () {
        var errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.opacity = 0; // Start fade-out
                setTimeout(function () {
                    errorMessage.style.display = 'none'; // Hide after fade-out
                }, 500); // Time for fade-out animation
            }, 2000); // Delay for 2 seconds before starting fade-out
        }
    });
</script>

@endsection
