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
            <h2><b>Account Users</b></h2>
        </div>

        <div class="container-fluid p-0">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th style="color: #fff !important;">Sr No.</th>
                                            <th style="color: #fff !important;">Email</th>
                                            <th style="color: #fff !important;">Password</th>
                                            <th style="color: #fff !important;">Manager</th>
                                            <th style="color: #fff !important;">Team Lead</th>
                                            <th style="color: #fff !important;">Role</th>
                                            <th style="color: #fff !important;">Created at</th>
                                            <th style="color: #fff !important;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach($getAccountsUser as $getaccount)
                                        <tr>
                                            <td class="dynamic-data">{{ $i++ }}</td>
                                            <td class="dynamic-data">{{ $getaccount->name }}</td>
                                            <td class="dynamic-data">**********</td> <!-- Hide password -->
                                            <td class="dynamic-data">{{ $getaccount->manager }}</td>
                                            <td class="dynamic-data">{{ $getaccount->team_lead }}</td>
                                            <td class="dynamic-data">{{ $getaccount->role }}</td>
                                           <td class="dynamic-data">{{ $getaccount->created_at ? \Carbon\Carbon::parse($getaccount->created_at)->format('m-d-y') : '' }}</td>
                                            <td class="dynamic-data" style="text-align: center;">
                                                <a data-toggle="modal" style="margin-right:7px;" data-target="#editAccountModal" data-id="{{ $getaccount->id }}" class="editAccount"><i class="fa fa-edit" style="color:#0DCAF0;font-size: 17px;margin-left: 13px;cursor: pointer;"></i></a>
                                                <a href="javascript:void(0);" class="deleteAccount" data-id="{{ $getaccount->id }}"><i class="fa fa-trash" style="color:red;font-size: 17px;cursor: pointer;"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Edit Account Modal -->
                                <div class="modal fade" id="editAccountModal" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAccountModalLabel">Edit Account</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editAccountForm">
                                                    @csrf
                                                    <input type="hidden" name="id" id="account_id">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" id="username" name="username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="text" class="form-control" id="password" name="password">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="manager">Manager</label>
                                                        <input type="text" class="form-control" id="manager" name="manager">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="team_lead">Team Leader</label>
                                                        <input type="text" class="form-control" id="team_lead" name="team_lead">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="role">Role</label>
                                                        <input type="text" class="form-control" id="role" name="role">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="created_at">Created At</label>
                                                        <input type="text" class="form-control" id="created_at" name="created_at" readonly>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="text-center mb-4">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-info" id="saveChanges">Save changes</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>>

<script>
$(document).ready(function() {
    // Edit user
    $('.editAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Make an AJAX request to fetch user details
        $.ajax({
            url: '/user/' + accountId + '/edit',
            method: 'GET',
            success: function(response) {
                // Populate the form fields with the response data
                $('#account_id').val(response.id);
                $('#username').val(response.username);
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
            url: '/user/update',
            method: 'POST',
            data: formData,
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

    // Delete user
    $('.deleteAccount').on('click', function() {
        var accountId = $(this).data('id');

        // Confirm deletion
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '/user/' + accountId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token
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
@endsection
