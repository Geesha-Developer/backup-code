@extends('layouts.admin.app')

@section('content')
<style>
    .form-control {
        font-size: 14px;
        background: rgba(0, 0, 0, 0);
        height: auto;
        width: 50%;
    }
    .form {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 20px;
        background: #f1f3f4;
        padding: 14px 0;
    }
        .form .btn.btn-primary {
        font-size: 14px;
        padding: 9px 20px;
        background: #555555;
    }
    @media (min-width: 576px){
select.form-control, input#customer_city, input#customer_zip, input.form-control {
    height: 30px !important;
    font-size: 12px;
}
}

</style>
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
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2>New Register User</h2>
        </div>

        <div class="container-fluid">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                        <form method="POST" action="{{ route('register.user') }}" class="col-md-8 offset-md-2 form">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-right">{{ __('Full Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror w-100" name="name"
                                            value="{{ old('name') }}" Placeholder="Enter Full Name" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-right">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror w-100" name="email" value="{{ old('email') }}" Placeholder="Enter Email Address" required autocomplete="email">


                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-right">{{ __('Confirm Email Address') }}</label>

                                    <div class="col-md-6">
                                    <input id="confirm_email" type="email" class="form-control @error('email') is-invalid @enderror w-100" name="confirm_email" value="{{ old('email') }}" Placeholder="Confirm Email Address" required autocomplete="email">


                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                    <div style="position: relative;">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror w-100" name="password"
                                            required autocomplete="new-password" placeholder="Enter Password">
                                        <button type="button" id="togglePassword" style="position: absolute;top: 46%;transform: translateY(-50%);border: unset;background: #b5b5b5;font-size: 17px;right: 0;border-radius: 6px;">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>



                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control w-100"
                                            name="password_confirmation" required autocomplete="new-password" Placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Employe Code') }}</label>

                                    <div class="col-md-6">
                                        <input id="emp_code" type="text" class="form-control w-100" placeholder="Enter Employe Code" name="emp_code">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Full Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text" class="form-control w-100" placeholder="Enter Full Address" name="address" required
                                            autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="office"
                                        class="col-md-4 col-form-label text-right">{{ __('Assign Office') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control w-100" name="office" required>
                                            <option value="">Please Select Office</option>
                                            @foreach ($offices as $office)
                                            <option value="{{ $office->office_name }}">{{ $office->office_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Assign Manager') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control w-100" name="manager" id="manager" required>
                                            <option>Please Select Manager</option>
                                            @foreach ($manager as $managers)
                                            <option value="{{ $managers->manager }}">{{ $managers->manager }}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Assign Team Lead') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-control w-100" name="team_lead" id="team_lead" required>
                                            <option>Please Select Team Leader</option>
                                            @foreach($team_leader as $tl)
                                            <option value="{{ $tl->tl }}">{{ $tl->tl }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-right">{{ __('Emergency Contact') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="number" class="form-control w-100" placeholder="Enter Emergency Contact" name="emergency_contact">
                                    </div>
                                </div>


                                <div class="row mb-0">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('email').addEventListener('input', function(event) {
        var inputValue = event.target.value;
        var atIndex = inputValue.indexOf('@');
        
        // Handle backspace
        if (event.inputType === 'deleteContentBackward') {
            return; // Don't do anything for backspace
        }
        
        // Append "cargoconvoy.co" if not already present after '@'
        if (atIndex !== -1) {
            var domain = inputValue.slice(atIndex + 1);
            if (!domain.endsWith('cargoconvoy.co')) {
                var username = inputValue.slice(0, atIndex + 1);
                event.target.value = username + 'cargoconvoy.co';
            }
        }
    });
</script>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        var togglePassword = document.getElementById('togglePassword');
        var passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Change icon based on the password visibility
            var icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
            icon.setAttribute('aria-hidden', true);
        });
    });
</script>


@endsection