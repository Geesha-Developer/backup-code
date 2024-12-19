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
    .content .body_scroll .nav1 {
        padding: 2px 0 4px 0;
    margin-bottom: 9px;
    background: #c7c7c6;
    align-items: start;
    width: 100%;
    display: flex;

}
.content .body_scroll .nav {
    padding: 2px 0 4px 0 !important;
}
li{
    list-style: none;
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>View Leaders</b></h2>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab"
                    aria-controls="dashboard" aria-selected="true"
                    style="font-size: 15px;color: #000;font-weight:500">Add Leader</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="carriers-tab" data-bs-toggle="tab" href="#carriers" role="tab"
                    aria-controls="carriers" aria-selected="false"
                    style="font-size: 15px;color: #000;font-weight:500">Operations Teams</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <form id="leaderForm" action="{{ route('leader.add') }}" method="post" onsubmit="return validateCheckboxes()">
                @csrf
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="leader" style="margin-bottom: 7px;font-weight: 600;font-size: 16px;color: #4a4a4a;">Leader Name</label>
                                <input type="text" class="form-control" id="leader" name="leader" autocomplete="off" style="background: #fff; padding: 17px 8px;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="leader_email" style="margin-bottom: 7px;font-weight: 600;font-size: 16px;color: #4a4a4a;">Leader Email</label>
                                <input type="email" class="form-control" id="leader_email" name="leader_email" autocomplete="off" style="background: #fff; padding: 17px 8px;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="leader_office" style="margin-bottom: 7px; font-weight: 600; font-size: 16px; color: #4a4a4a;">Leader Office</label>
                                <select class="form-control" id="leader_office" name="leader_office" autocomplete="off" style="background: #fff;" required>
                                    <option value="">Please Select Office</option>
                                    @foreach($offices as $offc)
                                        <option value="{{ $offc->office_name }}">{{ $offc->office_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="leader_manager" style="margin-bottom: 7px; font-weight: 600; font-size: 16px; color: #4a4a4a;">Assign Manager</label>
                                <select class="form-control" id="leader_manager" name="leader_manager" autocomplete="off" style="background: #fff;" required>
                                    <option value="">Please Select Manager</option>
                                    <option value="Amren">Amren</option>
                                    <option value="Adam">Adam</option>
                                    @php
                                        $managers = \App\Models\Manger::all();
                                    @endphp
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="checkbox d-flex">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="managerCheckbox" name="Manager" value="1">
                                    <label class="form-check-label" for="managerCheckbox">Manager</label>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="tlCheckbox" name="TL" value="1">
                                    <label class="form-check-label" for="tlCheckbox">TL</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="tab-pane fade" id="carriers" role="tabpanel" aria-labelledby="carriers-tab">
            <ul class="nav1 nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="manager-tab" data-bs-toggle="tab" href="#manager" role="tab"
                    aria-controls="manager" aria-selected="true"
                    style="font-size: 15px;color: #000;font-weight:500">Manager List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="team-tab" data-bs-toggle="tab" href="#team" role="tab"
                    aria-controls="team" aria-selected="false"
                    style="font-size: 15px;color: #000;font-weight:500">Team Leader List</a>
            </li>
        </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="manager" role="tabpanel" aria-labelledby="manager-tab">
                
                  <div class="table-responsive" style="max-height: 70vh;">
                    <table class="table table-bordered dataTable no-footer">
                        <label for="customer_name"
                            style="margin-bottom: 7px;font-weight: 600;font-size: 16px;color: #4a4a4a;">Manager List</label>
                        <thead>
                            <tr>
                                <th style="color: #fff !important;">Sr No.</th>
                                <th style="color: #fff !important;">Manager Name</th>
                                <th style="color: #fff !important;">Manager Email</th>
                                <th style="color: #fff !important;">Leader Manager</th>
                                <th style="color: #fff !important;">Office</th>
                                <th style="color: #fff !important;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                                $managers = \App\Models\Manger::all();
                            @endphp

                            @foreach ($managers as $manager)
                            <tr>
                                <td class="dynamic-data" style="">{{ $i++ }}</td>
                                <td class="dynamic-data" style="">{{ $manager->manager }}</td>
                                <td class="dynamic-data" style="">{{ $manager->leader_email }}</td>
                                <td class="dynamic-data" style="">{{ $manager->leader_manager }}</td>
                                <td class="dynamic-data" style="">{{ $manager->office }}</td>
                                <td class="dynamic-data" style="text-align:center">
                                    <a href="javascript:void(0)" class="edit-manager p-0" data-toggle="modal" data-target="#editManagerModal" data-id="{{ $manager->id }}"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i> </a>
                                    <form id="delete-form-{{ $manager->id }}" action="{{ route('manager.destroy', $manager->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <a type="submit" class="p-0" onclick="return confirm('Are you sure you want to delete this manager?');" title="Delete">
                                          <i class="fa fa-trash" style="font-size: 17px;color: red;"></i> 
                                        </a>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                
                   <div class="table-responsive" style="max-height: 70vh;">
                    <table class="table table-bordered table-responsive dataTable no-footer">
                        <label for="customer_name"
                            style="margin-bottom: 7px;font-weight: 600;font-size: 16px;color: #4a4a4a;">Team Leader List</label>
                        <thead>
                            <tr>
                                <th style="color: #fff !important;">Sr No.</th>
                                <th style="color: #fff !important;">Team Leader</th>
                                <th style="color: #fff !important;">Team Leader Email</th>
                                <th style="color: #fff !important;">Manager</th>
                                <th style="color: #fff !important;">Office</th>
                                <th style="color: #fff !important;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                                $teamLeader = \App\Models\TeamLeader::all();
                            @endphp

                            @foreach ($teamLeader as $tl)
                            <tr>
                                <td class="dynamic-data" style="">{{ $i++ }}</td>
                                <td class="dynamic-data" style="">{{ $tl->tl }}</td>
                                <td class="dynamic-data" style="">{{ $tl->leader_email }}</td>
                                <td class="dynamic-data" style="">{{ $tl->leader_manager }}</td>
                                <td class="dynamic-data" style="">{{ $tl->office }}</td>
                                <td class="dynamic-data" style="text-align:center">
                                    
                                    <a href="javascript:void(0)" class="edit-tl p-0" data-toggle="modal" data-target="#edittlModal" data-id="{{ $tl->id }}"><i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i></a>
                                    <form id="delete-form-{{ $tl->id }}" action="{{ route('teamleader.destroy', $tl->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <a type="submit" class="p-0" onclick="return confirm('Are you sure you want to delete this team leader?');" title="Delete">
                                           <i class="fa fa-trash" style="font-size: 17px;color: red;"></i>
                                        </a>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- Edit Manager Modal -->

    <div class="modal" id="editManagerModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Manager</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form id="editManagerForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="id" id="manager_id">
                        <div class="form-group">
                            <label for="manager_name">Manager Name</label>
                            <input type="text" class="form-control" id="manager_name" name="manager_name" value="">
                        </div>
                        <div class="form-group">
                            <label for="manager_email">Manager Email</label>
                            <input type="email" class="form-control" id="manager_email" name="manager_email" value="">
                        </div>
                        <div class="form-group">
                            <label for="leader_manager">Leader Manager</label>
                            <select class="form-control" name="leader_main_manager" id="leader_main_manager">
                                <option value="Amren">Amren</option>
                                <option value="Amren">Adam</option>
                                @php
                                    $managers = \App\Models\Manger::all();
                                @endphp
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" class="form-control" id="leader_main_manager" name="leader_main_manager" value=""> -->
                        </div>
                        <div class="form-group">
                            <label for="manager_office">Office</label>
                            <select class="form-control" id="manager_office" name="manager_office">
                                @foreach($offices as $offc)
                                    <option value="{{ $offc->office_name }}">{{ $offc->office_name }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="text" class="form-control" id="manager_office" name="manager_office" value=""> -->
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-info text-white">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="edittlModal" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edittlModalLabel">Edit Team Leader</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="editTeamLeaderForm">
    @csrf
    <input type="hidden" name="id" id="tl_id">

    <div class="form-group">
        <label for="tl_name">Team Leader Name</label>
        <input type="text" class="form-control" id="tl_name" name="tl_name" required>
    </div>

    <div class="form-group">
        <label for="tl_email">Leader Email</label>
        <input type="email" class="form-control" id="tl_email" name="tl_email" required>
    </div>

    <div class="form-group">
        <label for="tl_main_manager">Leader Manager</label>
        <select class="form-control" id="tl_main_manager" name="tl_main_manager">
            @foreach($teamLeader as $tls)
                <option value="{{ $tls->tl }}">{{ $tls->tl }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tl_office">Manager Office</label>
        <select class="form-control" id="tl_office" name="tl_office">
            @foreach($offices as $offc)
                <option value="{{ $offc->office_name }}">{{ $offc->office_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-info text-white">Save changes</button>
    </div>
</form>

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
    document.addEventListener('DOMContentLoaded', function () {
        var lastActiveTab = localStorage.getItem('lastActiveTab');
        if (lastActiveTab) {
            $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
        } else {
            $('#myTab a[data-bs-toggle="tab"]').first().tab('show');
        }

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = e.target.getAttribute('href');
            localStorage.setItem('lastActiveTab', targetTab);
        });
    });
</script>

<script>
    $(document).ready(function() {
    $('#leaderForm').on('submit', function(e) {
        e.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Validate the form data (you can add more validations if needed)
        if (!$('#leader_office').val()) {
            alert('Need to select office');
            return;
        }
        if (!$('#leader_manager').val()) {
            alert('Need to select manager');
            return;
        }

        $.ajax({
            url: "{{ route('leader.add') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('New Leader has been added!');
                    // Optionally reset the form or perform other actions
                    $('#leaderForm')[0].reset();
                } else {
                    alert('Error adding leader. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error adding leader. Please try again.');
            }
        });
    });
});

</script>



<script>
$(document).on('click', '.edit-manager', function() {
    var managerId = $(this).data('id');
    
    $.ajax({
        url: '/manager-edit/' + managerId, // Adjust the URL if needed
        type: 'GET',
        success: function(data) {
            // Fill the form with the manager's details
            $('#manager_id').val(data.id);
            $('#manager_name').val(data.manager);
            $('#manager_email').val(data.leader_email);
            $('#leader_main_manager').val(data.leader_manager);
            $('#manager_office').val(data.office);

            // Open the modal
        },
        error: function() {
            alert('Error fetching manager details.');
        }
    });
});

</script>

<script>
    $('#editManagerForm').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/manager/update', // Ensure this is the correct route
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    // Hide the modal
                    $('#editManagerModal').modal('hide');
                    
                    // Optionally, refresh the page or update the table row
                    location.reload();
                } else {
                    alert('Error updating manager details.');
                }
            },
            error: function(xhr) {
                // Log the response for debugging
                console.log(xhr.responseText);
                alert('Error updating manager details.');
            }
        });
    });
</script>

<script>
$(document).on('click', '.edit-tl', function() {
    var tlId = $(this).data('id');

    $.ajax({
        url: '/team-leader/' + tlId, // Adjust the URL if necessary
        type: 'GET',
        success: function(data) {
            // Fill the form with the Team Leader's details
            $('#tl_id').val(data.id);
            $('#tl_name').val(data.tl); 
            $('#tl_email').val(data.leader_email);
            
            // Set the value of the select option for tl_main_manager
            $('#tl_main_manager').val(data.leader_manager).trigger('change');
            
            // Set the value of the select option for tl_office
            $('#tl_office').val(data.office).trigger('change');
        },
        error: function() {
            alert('Error fetching Team Leader details.');
        }
    });
});

</script>
<script>
    $('#editTeamLeaderForm').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/teamleader/update', // Adjust the URL for the update action
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    // Hide the modal
                    $('#edittlModal').modal('hide');
                    
                    // Optionally, refresh the page or update the table row
                    location.reload(); // Reloads the page to reflect changes
                } else {
                    alert('Error updating Team Leader details.');
                }
            },
            error: function() {
                alert('Error updating Team Leader details.');
            }
        });
    });
</script>
<script>
function validateCheckboxes() {
    const managerCheckbox = document.getElementById('managerCheckbox');
    const tlCheckbox = document.getElementById('tlCheckbox');

    if (!managerCheckbox.checked && !tlCheckbox.checked) {
        alert('Please select at least one checkbox (Manager or TL).');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>
@endsection
