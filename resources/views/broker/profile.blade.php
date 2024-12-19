@extends('layouts.broker.app')
@section('content')

@if(session('success'))
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

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
    .content .card-body {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 20px;
        padding: 20px;
        background: #fff;
    }

    .content .card-body span {
        color: #000;
        font-family: 'Poppins';
        font-size: 14px;
        margin-left: 12px;
        font-weight: 500;
    }

    .content .card-body .table td {
        text-align: left;
    }

    .card-body hr {
        width: 100%;
        margin: 15px 11px;
    }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Profile </h2>
        </div>
       <div class="container-fluid">
            <div class="row pb-5">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="profile-pic-container">
                                <div class="profile-picture-container" style="border:unset;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);position: relative; display: inline-block;">
                                    <img id="profileImage" src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}"
                                        alt="avatar" class="rounded-circle img-fluid" style="width: 200px;height: 200px;">
                                    <label for="profilePictureInput" style="position: absolute; top: 33px; right: 0; cursor: pointer;">
                                        <i style="font-size: 16px;background: #27310c;color: #fff;padding: 8px 7px;border-radius: 30px;" class="fa fa-pen"></i>
                                    </label>
                                    <input type="file" id="profilePictureInput" name="profilePictureInput" accept="image/*" style="display: none;">
                                    <input type="hidden" name="_token" id="csrfToken" value="{{ csrf_token() }}">
                                </div>
                                @if($user)
                                <h5 class="my-1"><b>{{ $user->name }}</b></h5>
                                <!-- <p class="text-muted mb-1">{{ $user->email }}</p> -->
                                <p class="text-muted mb-4">
                                    <!-- {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y h:i:s a') }} -->
                                </p>
                                @if($user)

                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#password-change-modal">Change Password</button>
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#profile-change-modal">Edit Details</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body">
                            <ul class="list-group list-group-flush rounded-3">
                                <!-- Other list items -->
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fas fa-globe fa-lg text-warning"><span>Website</span></i>
                                    <p class="mb-0"><a href="https://cargoconvoy.co/">cargoconvoy.co</a></p>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-linkedin-in" style="color: #0077b5;"><span>Linkedin</span></i>
                                    <p class="mb-0"><a
                                            href="https://www.linkedin.com/company/96380307/admin/?lipi=urn%3Ali%3Apage%3Ad_flagship3_feed%3BZJ%2FYQY62QqSiz8czoXj0Hw%3D%3D">cargoconvoy.facebook</a>
                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fab fa-facebook" style="color: #0077b5;"><span>Facebook</span></i>
                                    <p class="mb-0"><a href="https://www.facebook.com/cargoconvoy/?_rdr">cargoconvoy.linkdin</a>
                                    </p>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i style='color:#0077b5' class='fas'>&#xf879;<span>Phone</span></i>

                                    <p class="mb-0"><a href="tel:+1 6104007068">+1 6104007068</a>
                                    </p>

                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <i class="fa fa-envelope" style="color: #0077b5;"><span>Email</span></i>

                                    <p class="mb-0"><a href="mailto:info@cargoconvoy.co">info@cargoconvoy.co</a>
                                    </p>

                                </li>

                                <!-- Other list items -->

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card-body mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <b class="mb-0">Employee Name</b>
                            </div>

                            <div class="col-md-10">
                                <p class="text-muted mb-0">{{ $user->name }}</p>
                            </div>
                            <hr>
                            <div class="col-md-2">
                                <b class="mb-0">Email</b>
                            </div>
                            <div class="col-md-10">
                                <p class="text-muted mb-0">{{ $user->email }} </a></p>
                            </div>
                            <hr>
                            <div class="col-md-2">
                                <b class="mb-0">Employee Code</b>
                            </div>
                            <div class="col-md-10">
                                <p class="text-muted mb-0">{{ $user->emp_code }}</P>
                            </div>
                            <hr>
                            <div class="col-md-2">
                                <b class="mb-0">Bio</b>
                            </div>
                            <div class="col-md-10">
                                <p class="text-muted mb-0">{{ $user->bio }}</p>
                            </div>
                            <hr>
                            <div class="col-md-2">
                                <b class="mb-0">Mobile</b>
                            </div>
                            <div class="col-md-10">
                                <p class="text-muted mb-0">{{ $user->emergency_contact }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="password-change-modal" tabindex="-1" role="dialog"
    aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordChangeModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST" action="{{ route('change.password') }}">
                    @csrf
                    <!-- Include CSRF token for Laravel -->
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation"
                            name="new_password_confirmation" required>
                    </div>
                    <div id="message" class="mt-3"></div> <!-- To show success/error messages -->
                    <button type="submit" class="btn btn-info">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@else
<p>No profile data found.</p>
@endif
@else
<p>You have to enter your details first</p>
@endif
<div class="modal fade" id="profile-change-modal" tabindex="-1" role="dialog" aria-labelledby="profileChangeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileChangeModalLabel">Profile Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="changedetail" method="POST" action="{{ route('update.user.details') }}">
                    @csrf
                    <!-- Include CSRF token for Laravel -->
                    <div class="form-group">
                        <label for="employe_code">Employee Code</label>
                        <input type="text" class="form-control" id="employe_code" name="employe_code"
                            value="{{ $user->emp_code }}">
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea class="form-control" id="bio" name="bio">{{ $user->bio }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"
                            value="{{ $user->emergency_contact }}">
                    </div>
                    <div id="message" class="mt-3"></div> <!-- To show success/error messages -->
                    <button type="submit" class="btn btn-info">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#changePasswordForm').on('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting normally

            $.ajax({
                url: "{{ route('change.password') }}", // Use named route
                method: "POST",
                data: $(this).serialize(), // Serialize form data
                success: function (response) {
                    $('#message').html('<div class="alert alert-success">' + response
                        .message + '</div>');
                    location.reload();
                    // $('#password-change-modal').modal('hide'); // Hide the modal on success
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    if (errors) {
                        $.each(errors, function (key, value) {
                            errorMessage += value[0] +
                                '<br>'; // Append error messages
                        });
                    } else {
                        errorMessage = 'An error occurred. Please try again.';
                    }
                    $('#message').html('<div class="alert alert-danger">' + errorMessage +
                        '</div>');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#changedetail').on('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'), // Get the action URL from the form
                method: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function (response) {
                    if (response.success) {
                        $('#message').html('<div class="alert alert-success">' + response
                            .message + '</div>');
                        location.reload();
                    } else {
                        var errors = response.errors;
                        var errorMessage = '';
                        $.each(errors, function (key, value) {
                            errorMessage += '<div>' + value[0] +
                                '</div>'; // Show the first error message for each field
                        });
                        $('#message').html('<div class="alert alert-danger">' +
                            errorMessage + '</div>');
                    }
                },
                error: function (xhr) {
                    $('#message').html(
                        '<div class="alert alert-danger">An error occurred. Please try again.</div>'
                    );
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to activate the last active tab or default to the first tab
        function activateTab() {
            // Get the active tab from localStorage
            var activeTab = localStorage.getItem('activeTab');

            // Remove 'active' and 'show' classes from all tabs and content panes
            document.querySelectorAll('.nav-link').forEach(function (tab) {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(function (pane) {
                pane.classList.remove('active', 'show');
            });

            if (activeTab) {
                // Activate the last active tab if available
                var selectedTab = document.querySelector(`#myTab a[href="${activeTab}"]`);
                if (selectedTab) {
                    selectedTab.classList.add('active');
                    document.querySelector(activeTab).classList.add('active', 'show');
                }
            } else {
                // Default to the first tab if no active tab is stored
                var defaultTab = document.querySelector('#myTab .nav-link');
                if (defaultTab) {
                    defaultTab.classList.add('active');
                    document.querySelector(defaultTab.getAttribute('href')).classList.add('active', 'show');
                }
            }
        }

        // Store the clicked tab in localStorage
        document.querySelectorAll('.nav-link').forEach(function (tab) {
            tab.addEventListener('click', function () {
                localStorage.setItem('activeTab', this.getAttribute('href'));
            });
        });

        // Activate the last active tab or default tab on page load
        activateTab();
    });
</script>
<script>
    $(document).ready(function() {
    $('#profilePictureInput').on('change', function() {
        var formData = new FormData();
        var file = $('#profilePictureInput')[0].files[0];
        var token = $('#csrfToken').val();

        if (file) {
            formData.append('profile_picture', file);
            formData.append('_token', token);

            $.ajax({
                url: '{{ route("profile.picture.update") }}',  // Laravel route to handle profile update
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        // Update the profile image preview
                        $('#profileImage').attr('src', response.image_path);
                        alert('Profile picture updated successfully!');
                        location.reload();
                    } else {
                        alert('An error occurred while uploading the profile picture.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        });
    });
</script>
@endsection
