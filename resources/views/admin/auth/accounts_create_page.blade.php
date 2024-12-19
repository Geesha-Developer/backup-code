@extends('layouts.admin.app')
@section('content')
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
<style>
    .form select#team_lead {
        height: auto !important;
    }

    .form select#manager {
        height: auto !important;
    }

    .form input {
        height: 33px !important;
    }

</style>
<section class="content">
   <div class="body_scroll">
   <div class="block-header">
            <h2><b>Create Accounting Users</b></h2>
        </div>
        <div class="col-md-6 offset-md-3">
            <div class="form"
                style="box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 20px;background: #f1f3f4;margin: 16% 0;padding: 14px 25px;">
                <div class="text-center">
                    <h3 style="font-size: 26px; font-weight: 700;">Create Account</h3>
                </div>
                <form action="{{ route('create.new.login') }}" id="registrationForm" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="name"><b>Name:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="email"><b>Email:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="password"><b>Password:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="confirm_password"><b>Confirm Password:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                required>
                            <div class="invalid-feedback" id="passwordError" style="display: none;">Password not match
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="password"><b>Manager:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <select name="manager" id="manager" class="form-control" required>
                            <option value="">Select Manager</option>
                            <option value="Amren">Amren</option>
                            <option value="Adam">Adam</option>
                            @php $managers = App\Models\Manger::get(); @endphp
                                @foreach($managers as $manager)
                                <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="team_lead"><b>Team Leader: </b><code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <select name="team_lead" id="team_lead" class="form-control" required>
                                <option value="">Select Team Lead</option>
                                <option value="Adam">Adam</option>
                                @php $tls = App\Models\TeamLeader::get(); @endphp
                                @foreach($tls as $tl)
                                <option value="{{ $tl->tl }}">{{ $tl->tl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="text">
                                <label for="name"><b>Role:</b> <code>*</code></label>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <!-- <input type="text" name="role" id="role" value="Accounts" disabled class="form-control"
                                required> -->
                                <select class="form-control"  name="role" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="Accounts">Accounts</option>
                                    <option value="Compliance">Compliance</option>
                                </select>
                        </div>

                    </div>
                    <div class="text-center col-md-12 mt-3">
                        <input type="submit" class="mt-3 btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
   </div>
</section>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('#registrationForm').submit(function(event) {
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();

        if (password !== confirmPassword) {
            event.preventDefault();
            $('#passwordError').show();
        } else {
            $('#passwordError').hide();
        }
    });

    $('.editAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Make an AJAX request to fetch user details
        $.ajax({
            url: '/account/' + accountId + '/edit',
            method: 'GET',
            success: function(response) {
                // Populate the form fields with the response data
                $('#account_id').val(response.id);
                $('#username').val(response.name);
                $('#password').val(''); // Leave password field blank for security
                $('#manager').val(response.manager);
                $('#team_lead').val(response.team_lead);
                $('#role').val(response.role);
                $('#created_at').val(response.created_at);

                // Show the modal
                $('#editAccountModal').modal('show');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error fetching user data.');
            }
        });
    });

    // Save changes
    $('#saveChanges').on('click', function() {
        var formData = $('#editAccountForm').serialize();

        $.ajax({
            url: '/account/update',
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('User updated successfully.');
                location.reload(); // Reload the page to see the changes
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error updating user.');
            }
        });
    });

    $('.deleteAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Confirm deletion
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/account/' + accountId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('User deleted successfully.');
                    location.reload(); // Reload the page to see the changes
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error deleting user.');
                }
            });
        }
    });
});
</script>

@endsection