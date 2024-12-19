<!-- resources/views/auth/passwords/email.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form id="resetPasswordForm">
                        @csrf
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="emailError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                        <div id="message" class="mt-3"></div> <!-- To show success/error messages -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script><script>
$(document).ready(function() {
    $('#resetPasswordForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        $.ajax({
            url: '{{ route("password.email") }}',
            method: 'POST',
            data: $(this).serialize(), // Serialize form data
            success: function(response) {
                $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                $('#emailError').text('');
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    $('#emailError').text('Email does not exist');
                } else {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>'; // Append error messages
                        });
                    } else {
                        errorMessage = 'An error occurred. Please try again.';
                    }
                    $('#message').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                }
            }
        });
    });
});
</script>

@endsection
