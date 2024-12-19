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
        tbody tr:hover {
    background: #CAF1EB !important;
}
#fileList li {
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
button.dt-button {
    padding: 1px 10px;
    font-size: 13px;
}
.color-pallet .triangle-up {
    margin-right: 5px;
    border: 1px solid #545050;
    padding: 8px;
}
.color-pallet li{
    font-size: 13px;
    display: flex;
    font-weight: 600;
    margin: 0 9px;
    vertical-align: middle;
    align-items: center;
}
.color-pallet hr {
    border: 1px solid rgb(151 151 151);
    margin: 0;
    height: unset;
}
</style>

<section class="content">
        <div class="body_scroll">
            <div class="block-header">
               <h2><b>Vendor Management</b></h2>
            </div>
            
            <div class="d-flex justify-content-between">
                <div class="load-search mb-2">
                    <input type="text" class="form-control" id="loadNumberSearch" placeholder="Search Load #">
                </div>
                <ul class="d-flex color-pallet m-0">
                    <li><div class="triangle-up" style="background: #f9e79f;"></div>Open</li><hr>
                    <li><div class="triangle-up" style="background: #ffcccb;"></div>Delivered</li><hr>
                    <li><div class="triangle-up" style="background: #82e0aa;"></div>Invoiced</li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered dataTable no-footer load_number" data-page-length="50">
                    <thead>
                        <tr>
                            <th>Load#</th>
                            <th>Customer</th>
                            <th>Carrier</th>
                            <th>Status</th>
                            <th>Load Created</th>
                            <th>Dispatcher</th>
                            <th>Due Date</th>
                            <th>Quick Pay %</th>
                            <th>Payment Method</th>
                            <th>Ready to Pay</th>
                            <th>Carrier Payment</th>
                            <th>Carrier Files Upload</th>
                            <th>Carrier Files</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendormanagement as $vendor)
                        <tr class="load-row 
                            @if ($vendor->load_status === 'Open') 
                                row-open 
                            @elseif ($vendor->load_status === 'Delivered' && $vendor->invoice_status === 'Paid') 
                                row-delivered-paid 
                            @elseif ($vendor->load_status === 'Delivered' && $vendor->invoice_status === 'Paid Record') 
                                row-delivered-paid-record 
                            @elseif ($vendor->load_status === 'Delivered') 
                                row-delivered 
                            @endif" 
                            data-created-at="{{ $vendor->created_at->format('m-d-Y') }}">   
                            <td class="dynamic-data" id="load_number"><a style="color: #0c7ce6 !important;font-weight: 700;cursor:pointer;" onclick="openUploadWindow('{{ route('accounting.load.edit', $vendor->id) }}')">{{ $vendor->load_number }}</a></td>
                            <td class="dynamic-data">{{ $vendor->load_bill_to }}</td>
                            <td class="dynamic-data">{{ $vendor->load_carrier }}</td>
                            <td class="dynamic-data">{{ $vendor->load_status }}</td>
                            <td class="dynamic-data">
                                {{ \Carbon\Carbon::parse($vendor->created_at)->format('m-d-Y') }}
                            </td>

                            <td class="dynamic-data">{{ $vendor->user->name }}</td>
                            <td class="dynamic-data">
                                @if($vendor->load_carrier_due_date != '' && $vendor->load_carrier_due_date != 'null') 
                                    {{ $vendor->load_carrier_due_date }}
                                @else
                                    <input type="date" class="load_carrier_due_date" name="load_carrier_due_date" value="{{ $vendor->load_carrier_due_date }}" data-id="{{ $vendor->id }}">
                                @endif
                            </td>
                            <td class="dynamic-data">
                                <select style="width: 100%;" name="quick_pay" class="quick_pay" data-id="{{ $vendor->id }}">
                                    <option value="{{ $vendor->quick_pay }}">{{ $vendor->quick_pay ?? 'Please Select Quick Pay' }}</option>
                                    <option value="6%">6%</option>
                                    <option value="4%">4%</option>
                                </select>
                            </td>
                            <td class="dynamic-data">
                                <select style="width: 100%;" name="payment_method" class="payment_method" data-id="{{ $vendor->id }}">
                                    <option value="{{ $vendor->payment_method }}">{{ $vendor->payment_method ?? 'Please Select Payment Method' }}</option>
                                    <option value="ACH">ACH</option>
                                    <option value="Quick Pay">Quick Pay</option>
                                    <option value="OTR">OTR</option>
                                    <option value="Zelle">Zelle</option>
                                    <option value="Check">Check</option>
                                    <option value="Wire">Wire</option>
                                    <option value="Buyout">Buyout</option>
                                </select>
                            </td>
                            <td class="dynamic-data">
                                <select style="width: 100%;" name="ready_to_pay" class="ready_to_pay" data-id="{{ $vendor->id }}">
                                    <option value="{{ $vendor->ready_to_pay }}">{{ $vendor->ready_to_pay ?? 'Please Select Ready to Pay' }}</option>
                                    <option value="Yes" style="background-color: green; color: white;">Yes</option>
                                    <option value="No" style="background-color: red; color: white;">No</option>
                                    <option value="Hold" style="background-color: yellow; color: black;">Hold</option>
                                </select>
                            </td>
                            <td class="dynamic-data">
                                @if ($vendor->carrier_mark_as_paid != 'Paid')
                                    <input type="checkbox" class="carrier_mark_as_paid" name="carrier_mark_as_paid" data-id="{{ $vendor->id }}" {{ $vendor->carrier_mark_as_paid == 'Paid' ? 'checked' : '' }}>
                                @else
                                    Paid
                                @endif
                            </td>
                            <td class="dynamic-data">
                                <input type="file" class="carrierDoc" name="carrierDoc[]" multiple data-id="{{ $vendor->id }}">
                                <div class="progress" style="display:none; margin-top:10px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </td>
                            @if($vendor->carrierDoc)
                            <td class="text-center dynamic-data">
                                <a class="view-files" data-toggle="modal" data-id="{{ $vendor->id }}" data-target="#filesModal">
                                <i class="fa fa-eye" style="font-size: 16px;"></i>
                                </a>
                            </td>
                            @else
                            <td class="dynamic-data"><p style="font-size:7px;color:red">No files uploaded</p></td>
                            @endif
                            <!-- <td class="text-center dynamic-data">
                                <button type="button" style="background: none;padding: 8px 7px;" class="btn" data-toggle="modal" data-target="#edit-detail">
                                    <i class="fa fa-edit" style="font-size: 16px; color: #0DCAF0;"></i>
                                </button>
                            </td> -->
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
        // Apply initial color based on the current value
        document.querySelectorAll('.ready_to_pay').forEach(function(select) {
            updateColor(select);

            // Add event listener to change color when selection changes
            select.addEventListener('change', function() {
                updateColor(this);
            });
        });

        function updateColor(select) {
            switch (select.value) {
                case 'Yes':
                    select.style.backgroundColor = 'green';
                    select.style.color = 'white';
                    break;
                case 'No':
                    select.style.backgroundColor = 'red';
                    select.style.color = 'white';
                    break;
                case 'Hold':
                    select.style.backgroundColor = 'yellow';
                    select.style.color = 'black';
                    break;
                default:
                    select.style.backgroundColor = '';  // Default color
                    select.style.color = '';  // Default color
                    break;
            }
        }
    });
</script>
<script>
    $(document).ready(function () {
        // Array of table and input ID pairs
        var tables = [
            { tableClass: '.load_number', inputId: '#loadNumberSearch' },
        ];

        // Loop through each table-input pair
        tables.forEach(function (entry) {
            var table = $(entry.tableClass).DataTable();
            $(entry.inputId).on('keyup', function () {
                table
                    .columns(0)
                    .search(this.value)
                    .draw();
            });
        });
    });
</script>
@endsection