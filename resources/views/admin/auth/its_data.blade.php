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
    ul#fileList li {
    padding: 9px 12px;
    border-radius: 7px;
    margin-bottom: 18px;
    box-shadow: 0 4px 8px 0 rgb(0 0 0 / 10%), 0 6px 20px 0 rgb(0 0 0 / 4%);
    justify-content: space-between;
    display: flex;
}
ul#fileList li a{
    color:#000;
}
#fileViewModal .modal-header {
    background: #555;
    padding: 10px 28px !important;
    color: #fff;
    font-size: 13px;
}
#fileViewModal .close {
    color: #ffffff !important;
    top: 15px !important;
}
#fileList img {
    margin-right: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
ul#fileList {
    padding-inline-start: 0;
}
.modal.fade.show {
    background: #00000075;
}
.form-group label{
    margin-bottom: 0;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
    color: #4a4a4a;
}
.modal-open .modal {
    background: #0000007d;
}
.form-check {
    margin-left: 1rem;
}

.form-check-input {
    margin-right: 0.5rem;
}
.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>

<section class="content">
        <div class="body_scroll">
            <div class="block-header">
               <h2><b>Its Data</b></h2>
            </div>
        
            <div class="table-responsive">
                <table class="table table-bordered table-responsive dataTable no-footer" id="dataTable">
                    <thead>
                        <tr>
                            <th style="color: #fff !important;">Load #</th>
                            <th style="color: #fff !important;">Agent Name</th>
                            <th style="color: #fff !important;">Invoice #</th>
                            <th style="color: #fff !important;">Invoice Date</th>
                            <th style="color: #fff !important;">W/O #</th>
                            <th style="color: #fff !important;">Customer Name</th>
                            <th style="color: #fff !important;">Office</th>
                            <th style="color: #fff !important;">Manager</th>
                            <th style="color: #fff !important;">Team Leader</th>
                            <th style="color: #fff !important;">Load Create Date</th>
                            <th style="color: #fff !important;">Shipper Date</th>
                            <th style="color: #fff !important;">Delivery date</th>
                            <th style="color: #fff !important;">Actual Delivery date</th>
                            <th style="color: #fff !important;">Carrier MC</th>
                            <th style="color: #fff !important;">Carrier Name</th>                                                
                            <th style="color: #fff !important;">Pickup Location</th>
                            <th style="color: #fff !important;">Unloading Location</th>
                            <th style="color: #fff !important;">Load Status</th>
                            <th style="color: #fff !important;">Aging</th>
                            <!-- <th style="color: #fff !important;">Carrier PDF</th>
                            <th style="color: #fff !important;">Shipper PDF</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($its as $load)
                        <tr>
                            <td class="dynamic-data"><a style="color: rgb(10 185 90) !important;font-weight: 700;" href="{{ route('admin.load.edit', $load->id) }}">{{ $load->load_number }}</a></td>
                            <td class="dynamic-data">{{ $load->load_dispatcher }}</td>
                            <td class="dynamic-data">{{ $load->invoice_number }}</td>
                            <td class="dynamic-data">{{ $load->invoice_date}}</td>
                            <td class="dynamic-data">{{ $load->load_workorder }}</td>
                            <td class="dynamic-data">{{ $load->load_bill_to }}</td>
                            <td class="dynamic-data">{{ isset($load->user->office) }}</td>
                            <td class="dynamic-data">{{ isset($load->user->manager) }}</td>
                            <td class="dynamic-data">{{ isset($load->user->team_lead) }}</td>
                            <td class="dynamic-data">{{ $load->created_at }}</td>
                                @php
                                $shipper_appointment = json_decode($load->load_shipper_appointment,true);
                                @endphp
                            <td class="dynamic-data">{{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('Y-m-d') : '' }}</td>
                                @php
                                    $consignee_appointment = json_decode($load->load_consignee_appointment,true);
                                @endphp
                            <td class="dynamic-data"> {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('Y-m-d') : '' }}
                            </td>
                            <td class="dynamic-data">{{ $load->load_actual_delivery_date }}</td>
                            <td class="dynamic-data">{{ $load->load_mc_no }}</td>
                            <td class="dynamic-data">
                                {{ $load->load_carrier }}</td>
                            @php
                                $shipper_location = json_decode($load->load_shipper_location,true);
                            @endphp
                            <td class="dynamic-data">
                                {{ $shipper_location[0]['location'] ?? '' }}
                            </td>
                            @php
                                $consignee_loaction = json_decode($load->load_consignee_location,
                            true);
                            @endphp

                            <td class="dynamic-data">
                                {{ $consignee_loaction[0]['location'] ?? '' }}
                            </td>
                            <td class="dynamic-data">
                                {{ $load->load_status }}
                            </td>
                            <td class="dynamic-data">
                                @if($load->load_status == 'Delivered' ||
                                $load->invoice_status == 'Completed' )
                                @php
                                $deliveredDate = \Carbon\Carbon::parse($load->created_at);
                                $currentDate = \Carbon\Carbon::now();
                                $differenceInDays = $deliveredDate->diffInDays($currentDate);
                                @endphp
                                {{ $differenceInDays }} days
                                @elseif($load->invoice_status == 'Completed' ||
                                $load->load_status == 'Delivered')
                                Aging Complete
                                @endif
                            </td>
                            <!-- <td class="dynamic-data" style="padding: 0 10px !important; vertical-align: middle !important;">
                                <a href="{{ route('admin.rc.download.pdf', ['id' => $load->id]) }}" target="_blank">
                                    <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
                                </a>
                            </td>
                            <td class="dynamic-data" style="padding: 0 10px !important; vertical-align: middle !important;">
                                <a href="{{ route('admin.shipper.rc.download.pdf', ['id' => $load->id]) }}" target="_blank">
                                    <i class="fas fa-file-pdf text-danger" aria-hidden="true" style="font-size: 24px;"></i>
                                </a>
                            </td> -->
                            <!-- <td class="dynamic-data"><button class="btn btn-sm btn-danger">Delete</button></td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <!-- <div class="modal fade" id="edit-detail" tabindex="-1" role="dialog" aria-labelledby="editDetailLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDetailLabel"><b>Edit</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dueDate">Due Date</label>
                                    <input type="date" class="form-control" id="dueDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quickPay">Quick Pay</label>
                                    <select class="form-control" id="quickPay">
                                        <option>6%</option>
                                        <option>4%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paymentMethod">Payment Method</label>
                                    <select class="form-control" id="paymentMethod">
                                        <option>Check</option>
                                        <option>ACH</option>
                                        <option>Quick Pay</option>
                                        <option>OTR</option>
                                        <option>Zelle</option>
                                        <option>Wire</option>
                                        <option>Buyout</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="readyToPay">Ready to Pay</label>
                                    <select class="form-control" id="readyToPay">
                                        <option>Yes</option>
                                        <option>No</option>
                                        <option>Hold</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div> -->



<!-- Modal Structure -->
<div class="modal fade" id="filesModal" tabindex="-1" role="dialog" aria-labelledby="filesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filesModalLabel">Uploaded Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="filesList">
                <!-- Files will be dynamically loaded here -->
            </div>
            <div class="text-center mb-3">
                <!-- <button type="button" class="btn btn-danger" id="delete-selected">Delete Selected</button>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="select-all">
                    <label class="form-check-label" for="select-all">Select All</label>
                </div> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>









<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        // Set CSRF token in AJAX header globally
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.load_carrier_due_date').change(function () {
            var date = $(this).val();
            var id = $(this).data('id'); // Retrieve the vendor ID from the data-id attribute

            $.ajax({
                url: '{{ route('update.load.date') }}',
                method: 'POST',
                data: {
                    id: id,
                    load_carrier_due_date: date
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Date updated successfully');
                        // Disable the input field after successful update
                        $(this).prop('disabled', true);
                    } else {
                        console.error('Failed to update date');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error updating date:', xhr.responseText);
                    alert('Error updating date');
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.carrier_mark_as_paid').change(function () {
            var isChecked = $(this).is(':checked');
            var id = $(this).data('id');

            $.ajax({
                url: '{{ route('update.load.checkbox') }}',
                method: 'POST',
                data: {
                    id: id,
                    carrier_mark_as_paid: isChecked ? 'Paid' : ''
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Date and status updated successfully');
                    } else {
                        console.error('Failed to update date and status');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error updating date and status:', xhr.responseText);
                    alert('Error updating date and status');
                }
            });
        });
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('select.quick_pay, select.payment_method, select.ready_to_pay').change(function() {
        var id = $(this).data('id');
        var quick_pay = $(this).closest('tr').find('.quick_pay').val();
        var payment_method = $(this).closest('tr').find('.payment_method').val();
        var ready_to_pay = $(this).closest('tr').find('.ready_to_pay').val();

        $.ajax({
            url: '{{ route("updateLoadDetails") }}', // Corrected URL with route helper
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                quick_pay: quick_pay,
                payment_method: payment_method,
                ready_to_pay: ready_to_pay
            },
            success: function(response) {
                // Handle success
                console.log('Data updated successfully');
            },
            error: function(response) {
                // Handle error
                console.log('Error updating data');
            }
        });
    });
});
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<script>
$(document).ready(function() {
    // Handle file upload
    $('.carrierDoc').on('change', function() {
        var input = $(this);
        var files = input[0].files;
        var id = input.data('id');
        var formData = new FormData();

        // Append files and ID to FormData
        for (var i = 0; i < files.length; i++) {
            formData.append('carrierDoc[]', files[i]);
        }
        formData.append('id', id);

        // Show the progress bar
        var progressBar = input.closest('td').find('.progress');
        var progressBarFill = progressBar.find('.progress-bar');
        progressBar.show();

        $.ajax({
            url: '/uploadCarrierDocs',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                // Upload progress
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                        progressBarFill.css('width', percentComplete + '%');
                        progressBarFill.attr('aria-valuenow', percentComplete);
                        progressBarFill.text(percentComplete + '%');
                    }
                }, false);

                return xhr;
            },
            success: function(response) {
                alert('Files uploaded successfully!');
                progressBar.hide(); // Hide the progress bar on success
                location.reload();
            },
            error: function() {
                alert('Failed to upload files.');
                progressBar.hide(); // Hide the progress bar on error
            }
        });
    });

    // Handle the click event on the "View Files" button
    $('.view-files').on('click', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '{{ route("get.files") }}',
            type: 'POST',
            data: { id: id },
            success: function (files) {
                var filesList = '';
                files.forEach(function(file, index) {
                    var srNo = index + 1;
                    filesList += '<li>' +
                        srNo + '. ' + // Adding the serial number before the file name
                        '<a href="' + file.url + '" target="_blank">' + file.name + '</a>' +
                        ' <a href="javascript:void(0);" class="delete-file" data-id="' + id + '" data-filename="' + file.name + '">' +
                            '<i class="fa fa-trash" style="color:red;"></i>' +
                        '</a>' +
                    '</li>';
                });
                $('#filesList').html('<ul id="fileList">' + filesList + '</ul>');
                $('#filesModal').modal('show');
            }
        });
    });

    // Handle the click event on the trash button to delete a single file
    $(document).on('click', '.delete-file', function() {
        var filename = $(this).data('filename');
        var id = $(this).data('id');
        var $fileItem = $(this).closest('li'); // Get the closest <li> element to remove it

        $.ajax({
            url: '{{ route("delete.carrier.doc") }}',
            type: 'POST',
            data: {
                id: id,
                filename: filename
            },
            success: function(response) {
                if (response.success) {
                    // Remove the <li> element from the DOM
                    $fileItem.remove();
                    alert('File deleted successfully!');
                } else {
                    alert('Failed to delete the file.');
                }
            },
            error: function() {
                alert('An error occurred while deleting the file.');
            }
        });
    });

    // Handle the click event on the "Delete Selected" button
    $('#delete-selected').on('click', function() {
        var selectedFiles = [];
        $('.file-checkbox:checked').each(function() {
            selectedFiles.push($(this).data('filename'));
        });

        if (selectedFiles.length === 0) {
            alert('No items selected. Please select items first.');
            return;
        }

        // Get the ID from the button that opened the modal
        var id = $('.view-files').data('id'); 

        $.ajax({
            url: '{{ route("delete.selected.files") }}',
            type: 'POST',
            data: {
                id: id,
                filenames: selectedFiles
            },
            success: function(response) {
                if (response.success) {
                    // Remove the checked <li> elements from the DOM
                    $('.file-checkbox:checked').each(function() {
                        $(this).closest('li').remove();
                    });
                    alert('Selected files deleted successfully!');
                } else {
                    alert('Failed to delete selected files.');
                }
            },
            error: function() {
                alert('An error occurred while deleting selected files.');
            }
        });
    });

    // Handle the click event on the "Select All" checkbox
    $('#select-all').on('change', function() {
        var isChecked = $(this).is(':checked');
        $('.file-checkbox').prop('checked', isChecked);
    });
});

</script>

@endsection