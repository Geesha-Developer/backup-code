@extends('layouts.admin.app')
@section('content')

<style>
    .toggle-label {
        position: relative;
        display: block;
        width: 188px;
        height: 37px;
        margin-top: -4px;
    }

    .toggle-label input[type=checkbox] {
        opacity: 0;
        position: absolute;
        width: auto;
        height: 44%;
    }

    .toggle-label input[type=checkbox]+.back {
        position: absolute;
        width: 75%;
        height: 84%;
        background: #ed1c24;
        transition: background 150ms linear;
        left: 0;
        top: 10px;
        border-radius: 20px;
    }

    .toggle-label input[type=checkbox]:checked+.back {
        background: #00a651;
        /* green */
    }

    .toggle-label input[type=checkbox]+.back .toggle {
        display: block;
    position: absolute;
    content: ' ';
    background: #fff;
    width: 52%;
    height: 100%;
    transition: margin 150ms linear;
    border: 1px solid #808080;
    border-radius: 20px;
    }

    .toggle-label input[type=checkbox]:checked+.back .toggle {
        margin-left: 69px;
    }

    .toggle-label .label {
        display: block;
        position: absolute;
        width: 56%;
        top: -24px;
        color: #ddd;
        line-height: 80px;
        text-align: center;
        font-size: 13px;
    }

    .toggle-label .label.on {
        left: 0px;
    }

    .toggle-label .label.off {
        right: 0px;
    }

    .toggle-label input[type=checkbox]:checked+.back .label.on {
        color: #fff;
    }

    .toggle-label input[type=checkbox]+.back .label.off {
        color: #fff;
    }

    .toggle-label input[type=checkbox]:checked+.back .label.off {
        color: #ddd;
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
            <h2><b>Add Office</b></h2>
        </div>
        <div class="container-fluid p-0">
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <form method="POST" action="{{ route('add.office') }}">
                            @csrf
                            <div class="body text-left">
                                <div class="row clearfix">
                                    <div class="col-md-12 p-2" style="background:#616C77;">
                                        <label for="office_name"
                                            style="margin-bottom: 7px;font-weight: 600;font-size: 16px;color: #fff;">Office
                                            Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="office_name"
                                                placeholder="Please enter the office name" name="office_name"
                                                autocomplete="off" required
                                                style="background: #fff; padding: 17px 8px;">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                style="padding: 0 14px; margin: 0; margin-left: 13px; background: #263544;">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="body">
                        
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th style="color: #fff !important;">Sr No.
                                            </th>
                                            <th style="color: #fff !important;">Office
                                                Name</th>
                                            <th style="color: #fff !important;">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($office_add as $office)
                                        <tr>
                                            <td class="dynamic-data">{{ $office->id }}</td>
                                            <td class="dynamic-data">{{ $office->office_name }}</td>
                                            <td class="dynamic-data d-flex justify-content-center">
                                                <label class="toggle-label">
                                                    <input type="checkbox" class="input-switch" data-office-id="{{ $office->id }}" {{ $office->status == 'Active' ? 'checked' : '' }}>
                                                    <span class="back">
                                                        <span class="toggle"></span>
                                                        <span class="label on">Active</span>
                                                        <span class="label off">Inactive</span>
                                                    </span>
                                                </label>

                                                <button class="edit-office btn btn-info text-white" data-toggle="modal" data-target="#editofficeModal" data-id="{{ $office->id }}"><i class="fa fa-edit"></i> Edit</button>
                                                <form action="{{ route('office.destroy', $office->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this office?');" class="btn btn-danger">Delete</button>
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
    </div>
    <div class="modal" id="editofficeModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Office</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form id="editOfficeForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="office_id">
                        <div class="form-group">
                            <label for="office_name">Office Name</label>
                            <input type="text" class="form-control" id="office" name="office" required>
                        </div>
                        <div class="form-group">
                            <label for="office_status">Office Status</label>
                            <select class="form-control" id="office_status" name="office_status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.input-switch').change(function () {
            var officeId = $(this).data('office-id');
            var status = this.checked ? 'Active' : 'Inactive';

            $.ajax({
                url: '/update-office-status/' + officeId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    status: status
                },
                success: function (data) {
                    if (data.success) {
                        console.log('Status updated successfully:', data.message);
                    } else {
                        console.error('Error updating status:', data.message);
                    }
                },
                error: function (error) {
                    console.error('Error updating status:', error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Edit button click event
        $(document).on('click', '.edit-office', function() {
            var officeId = $(this).data('id');

            $.ajax({
                url: '/admin/office/edit/' + officeId,
                type: 'GET',
                success: function(data) {
                    // Fill the form with the office details
                    $('#office_id').val(data.id);
                    $('#office').val(data.office_name);
                    $('#office_status').val(data.status);

                    // Open the modal
                },
                error: function() {
                    alert('Error fetching office details.');
                }
            });
        });

        // Form submission event
        $('#editOfficeForm').submit(function(e) {
            e.preventDefault();

            var officeId = $('#office_id').val();
            var formData = $(this).serialize();
            var updateUrl = "/admin/office/" + officeId; // Update URL based on the routes

            $.ajax({
                url: updateUrl,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if(response.success) {
                        // Hide the modal
                        $('#editofficeModal').modal('hide');

                        // Update the table row with the new data
                        var row = $('button.edit-office[data-id="' + officeId + '"]').closest('tr');
                        row.find('td:nth-child(2)').text($('#office').val());
                        row.find('td:nth-child(3) .label.on').text($('#office_status').val() === 'Active' ? 'Active' : 'Inactive');

                        // Optionally, show a success message
                        alert('Office details updated successfully.');
                        location.reload();
                    } else {
                        alert('Error updating office details.');
                    }
                },
                error: function() {
                    alert('Error updating office details.');
                }
            });
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