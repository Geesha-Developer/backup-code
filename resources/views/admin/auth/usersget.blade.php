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
    .table>:not(caption)>*>* {
        background-color: unset !important;
    }
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2><b>All Users Data</b> </h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th style="color: #fff !important;">Sr No.</th>
                                            <th style="color: #fff !important;">Emp Code</th>
                                            <th style="color: #fff !important;">Broker</th>
                                            <th style="color: #fff !important;">Email</th>
                                            <th style="color: #fff !important;">Address</th>
                                            <th style="color: #fff !important;">Office</th>
                                            <th style="color: #fff !important;">Manager</th>
                                            <th style="color: #fff !important;">Team Lead</th>
                                            <th style="color: #fff !important;">Emergency Number</th>
                                            <th style="color: #fff !important;">Created at</th>
                                            <th style="color: #fff !important;">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($getusers as $users)
                                        <tr>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $i++ }}</td>
                                            @if($users->emp_code)
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->emp_code }}</td>
                                            @else
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">NA</td>
                                            @endif
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->name }}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->email }}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->address}}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->office}}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->manager }}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->team_lead }}</td>
                                            @if($users->emp_code)
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->emergency_contact }}</td>
                                            @else
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->emergency_contact }}</td>
                                            @endif
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;">{{ $users->created_at->format('m-d-Y h:i:s A') }}</td>
                                            <td class="dynamic-data" style="padding: 9px 10px !important; vertical-align: middle !important;" class="d-flex justify-content-center">
                                                <a href="javascript:void(0);" data-id="{{ $users->id }}" class="editAccount" data-toggle="modal" data-target="#editAccount"><i class="fa fa-edit" style="color:#0DCAF0;font-size: 17px;cursor: pointer;"></i></a>
                                                
                                                <!--<a href="javascript:void(0);" class="deleteAccount" data-id="{{ $users->id }}"><i class="fa fa-trash" style="color:red"></i></a>-->
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="editAccount" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAccountModalLabel">Edit User</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editAccountForm">
                                                    @csrf
                                                    <input type="hidden" name="id" id="account_id">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="employee_code">Employee Code</label>
                                                                <input type="text" class="form-control" id="employee_code" name="employee_code">
                                                             </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="agent_name">Agent Name</label>
                                                                <input type="text" class="form-control" id="agent_name" name="agent_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="text" class="form-control" id="email" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="address">Address</label>
                                                                <input type="text" class="form-control" id="address" name="address">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="office">Office</label>
                                                                <input type="text" class="form-control" id="office" name="office">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="manager">Manager</label>
                                                                <input type="text" class="form-control" id="manager" name="manager">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="team_leader">Team Leader</label>
                                                                <input type="text" class="form-control" id="team_leader" name="team_leader">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="emergency_number">Emergency Number</label>
                                                                <input type="text" class="form-control" id="emergency_number" name="emergency_number">
                                                            </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <label for="created_at">Created At</label>
                                                        <input type="text" class="form-control" id="created_at" name="created_at" readonly>
                                                    </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="text-center mb-4">
                                                <button type="button" class="btn btn-info" id="saveChanges">Save changes</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button id="changePasswordBtn" class="btn btn-primary">Change Password</button>




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $('.editAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Make an AJAX request to fetch user details
        $.ajax({
            url: '/user/' + accountId + '/edit',
            method: 'GET',
            success: function(response) {
                // Populate the form fields with the response data
                $('#account_id').val(response.id);
                $('#agent_name').val(response.name);
                $('#password').val(''); // Leave password field blank for security
                $('#email').val(response.email );
                $('#address').val(response.address);
                $('#office').val(response.office);
                $('#manager').val(response.manager);
                $('#team_leader').val(response.team_lead);
                $('#emergency_number').val(response.emergency_contact);
                $('#employee_code').val(response.emp_code);
                var createdAt = new Date(response.created_at); // Convert the date string to a Date object
                var formattedDate = createdAt.toLocaleDateString('en-GB'); // Format the date to DD/MM/YYYY (you can adjust the locale)

                $('#created_at').val(formattedDate);  // Set the formatted date in the input field                  
                            // Show the modal
                            $('#editAccountModal').modal('show');
                },
        });
    });

    // Save changes
    $('#saveChanges').on('click', function() {
        var formData = $('#editAccountForm').serialize();

        $.ajax({
            url: '/user/update',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('User updated successfully.');
                location.reload(); // Reload the page to see the changes
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.deleteAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Confirm deletion
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/user/' + accountId,
                method: 'DELETE',
                success: function(response) {
                    alert('User deleted successfully.');
                    location.reload(); // Reload the page to see the changes
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while deleting the user.');
                }
            });
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        // Inject CSS dynamically via JavaScript
        var style = '<style>' +
                        'tbody tr.highlight-row {' +
                            'background-color: #CAF1EB !important;' +
                        '}' +
                    '</style>';
        $('head').append(style); // Append the style to the head

        // Event delegation to target the first <td> in each row
        $('tbody').on('click', 'td', function() {
            // Remove the highlight from any previously selected row
            $('tbody tr').removeClass('highlight-row');
            
            // Add highlight to the clicked row
            $(this).closest('tr').addClass('highlight-row');
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#changePasswordBtn').on('click', function () {
            // Send AJAX request to change password
            $.ajax({
                url: "{{ route('user.changePassword') }}", // Adjust the route as needed
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'  // CSRF token for security
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Your password has been changed. Check your email.");
                    } else {
                        alert("Something went wrong, please try again.");
                    }
                }
            });
        });
    });
</script>



@endsection