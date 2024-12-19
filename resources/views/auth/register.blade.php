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
        margin: 4% auto
    }

    .form .btn.btn-primary {
        font-size: 14px;
        padding: 9px 20px;
        background: #555555;
    }

    @media (min-width: 576px) {

        select.form-control,
        input#customer_city,
        input#customer_zip,
        input.form-control {
            height: 30px !important;
            font-size: 12px;
        }
    }
</style>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>New Register User</b></h2>
        </div>

        <div class="col-md-12">
            <form method="POST" action="{{ route('user.register') }}" class="col-md-6 offset-md-3 form">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-right"><b>Full Name</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror w-100" name="name"
                            value="{{ old('name') }}" placeholder="Enter Full Name" required
                            autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-right"><b>Email Address</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror w-100" name="email"
                            value="{{ old('email') }}" placeholder="Enter Email Address" required
                            autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="confirm_email" class="col-md-4 col-form-label text-right"><b>Confirm Email Address</b> <code>*</code></label>
                    <div class="col-md-6">
                        <input id="confirm_email" type="email"
                            class="form-control @error('confirm_email') is-invalid @enderror w-100"
                            name="confirm_email" value="{{ old('confirm_email') }}"
                            placeholder="Confirm Email Address" required autocomplete="email">
                        <span id="paste-error-email" style="color: red; display: none;">Paste not
                            allowed.
                            Please type your Confirm Email Address.</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-right"><b>Password</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <div style="position: relative;">
                            <input id="password" type="password" class="form-control w-100"
                                name="password" required autocomplete="new-password"
                                placeholder="Enter Password">
                            <button type="button" id="togglePassword"
                                style="position: absolute; top: 46%; transform: translateY(-50%); border: unset; background: #b5b5b5; font-size: 17px; right: 0; border-radius: 6px;">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-right"><b>Confirm Password</b> <code>*</code></label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control w-100"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm Password">
                        <span id="paste-error" style="color: red; display: none;">Paste not allowed.
                            Please type your password.</span>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="emp_code" class="col-md-4 col-form-label text-right"><b>Employe Code</b></label>
                    <div class="col-md-6">
                        <input id="emp_code" type="text" class="form-control w-100"
                            placeholder="Enter Employe Code" name="emp_code">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-right"><b>Full Address</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control w-100"
                            placeholder="Enter Full Address" name="address" required
                            autocomplete="address">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="office" class="col-md-4 col-form-label text-right"><b>Assign Office</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <select class="form-control w-100" name="office" id="office" required>
                            <option value="">Please Select Office</option>
                            @foreach ($offices as $office)
                            @if($office->status == 'Active')
                            <option value="{{ $office->office_name }}">{{ $office->office_name }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="manager" class="col-md-4 col-form-label text-right"><b>Assign Manager</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <select class="form-control w-100" name="manager" id="manager" required
                            disabled>
                            <option value="">Please Select Manager</option>
                            <option value="Amren">Amren</option>
                            <option value="Amren">Adam</option>
                            @foreach ($managers as $manager)
                            <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="team_lead" class="col-md-4 col-form-label text-right"><b>Assign Team Leader</b>
                        <code>*</code></label>
                    <div class="col-md-6">
                        <select class="form-control w-100" name="team_lead" id="team_lead" required
                            disabled>
                            <option value="">Please Select Team Leader</option>
                            @foreach ($team_leaders as $team_lead)
                            <option value="{{ $team_lead->tl }}">{{ $team_lead->tl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Validation Messages -->
                <div id="validationMessage" style="color: red; display: none;"></div>
                <div class="row mb-3">
                    <label for="emergency_contact" class="col-md-4 col-form-label text-right"><b>Emergency Contact</b><code>*</code></label>
                    <div class="col-md-6">
                        <input id="emergency_contact" type="text" class="form-control w-100"
                            placeholder="Enter Emergency Contact" name="emergency_contact" required>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-info">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var emailInput = document.getElementById('email');

        emailInput.addEventListener('input', function (event) {
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

        var togglePassword = document.getElementById('togglePassword');
        var passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change icon based on the password visibility
            var icon = this.querySelector('i');
            icon.className = type === 'password' ? 'fa fa-eye' : 'fa fa-eye-slash';
            icon.setAttribute('aria-hidden', true);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmPasswordInput = document.getElementById('password-confirm');
        var pasteError = document.getElementById('paste-error');

        confirmPasswordInput.addEventListener('paste', function (event) {
            event.preventDefault(); // Prevent paste
            pasteError.style.display = 'block'; // Show error message
        });

        confirmPasswordInput.addEventListener('input', function (event) {
            pasteError.style.display = 'none'; // Hide error message when user starts typing
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmPasswordInput = document.getElementById('confirm_email');
        var pasteError = document.getElementById('paste-error-email');

        confirmPasswordInput.addEventListener('paste', function (event) {
            event.preventDefault(); // Prevent paste
            pasteError.style.display = 'block'; // Show error message
        });

        confirmPasswordInput.addEventListener('input', function (event) {
            pasteError.style.display = 'none'; // Hide error message when user starts typing
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var officeSelect = document.getElementById('office');
        var managerSelect = document.getElementById('manager');
        var teamLeadSelect = document.getElementById('team_lead');
        var validationMessage = document.getElementById('validationMessage');

        // Enable/Disable manager select based on office selection
        officeSelect.addEventListener('change', function () {
            if (this.value !== '') {
                managerSelect.disabled = false;
                validationMessage.style.display = 'none';
            } else {
                managerSelect.disabled = true;
                managerSelect.value = '';
                teamLeadSelect.disabled = true;
                teamLeadSelect.value = '';
            }
        });

        // Enable/Disable team lead select based on manager selection
        managerSelect.addEventListener('change', function () {
            if (this.value !== '') {
                teamLeadSelect.disabled = false;
                validationMessage.style.display = 'none';
            } else {
                teamLeadSelect.disabled = true;
                teamLeadSelect.value = '';
            }
        });

        // Validation check on manager select
        managerSelect.addEventListener('focus', function () {
            if (officeSelect.value === '') {
                validationMessage.textContent = 'Need to select office';
                validationMessage.style.display = 'block';
                managerSelect.blur();
            }
        });

        // Validation check on team lead select
        teamLeadSelect.addEventListener('focus', function () {
            if (managerSelect.value === '') {
                validationMessage.textContent = 'Need to select manager';
                validationMessage.style.display = 'block';
                teamLeadSelect.blur();
            }
        });
    });
</script>