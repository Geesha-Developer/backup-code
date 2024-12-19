@extends('layouts.accounts.app')
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
.row-open {
    background-color: #f9e79f !important; /* Example color for Open */
}

.row-delivered {
    background-color: #d5dbdb !important; /* Example color for Delivered */
}

.row-delivered-paid {
    background-color: #82e0aa !important; /* Example color for Delivered & Paid */
}

.row-delivered-paid-record {
    background-color: #ffcccb !important; /* Example color for Delivered & Paid Record */
}
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

#view-file #file-list button {
    background: #ffffff;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border: none;
    width: 100%;
    text-align: left;
    padding: 8px 11px;
    margin-bottom: 10px;
    border-radius: 10px;
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
                <div class="load-search">
                    <input type="text" class="form-control" id="loadNumberSearch" placeholder="Search Load #">
                </div>
                <div class="d-flex flex-row-reverse">
                    <ul class="d-flex color-pallet m-0">
                        <li><div class="triangle-up" style="background: #f9e79f;"></div>Open</li><hr>
                        <li><div class="triangle-up" style="background: #ffcccb;"></div>Delivered</li><hr>
                        <li><div class="triangle-up" style="background: #82e0aa;"></div>Invoiced</li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 81vh;">
                <table class="table table-bordered no-footer load_number" data-page-length="50" id="dataTable">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Load#</th>
                            <th>W/O #</th>
                            <th>Customer</th>
                            <th>Carrier</th>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Status</th>
                            <th>Load Created</th>
                            <th>Dispatcher</th>
                            <th>Due Date</th>
                            <th>Carrier Due Date</th>
                            <th>Quick Pay %</th>
                            <th>Payment Method</th>
                            <th>Ready to Pay</th>
                            <th>Carrier Payment</th>
                            <th>Carrier Files Upload</th>
                            <th>Carrier Files</th>
                            <th>Agent Files</th>
                            <!-- <th>Comment</th> -->
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach($vendormanagement as $vendor)
                        <tr class="load-row {{ 
                            ($vendor->load_status == 'Open') ? 'row-open' : 
                            ($vendor->load_status == 'Delivered' && $vendor->invoice_status == 'Paid' ? 'row-delivered-paid' : 
                            ($vendor->load_status == 'Delivered' && $vendor->invoice_status == 'Paid Record' ? 'row-delivered-paid-record' : 
                            ($vendor->load_status == 'Delivered' ? 'row-delivered' : ''))) 
                        }}" data-created-at="{{ $vendor->created_at->format('m-d-Y') }}">
                            <td class="dynamic-data">{{ $i++ }}</td>
                            <td class="dynamic-data" id="load_number">
                            <a style="color: #007bff !important; font-weight: 700; cursor: pointer;" 
                                onclick="openUploadWindow('{{ route('accounting.load.edit', $vendor->id) }}')">
                                {{ $vendor->load_number }}
                            </a>

                            </td>
                            <td class="dynamic-data">{{ $vendor->load_workorder }}</td>
                            <td class="dynamic-data">{{ $vendor->load_bill_to }}</td>
                            <td class="dynamic-data">{{ $vendor->load_carrier }}</td>
                            <td class="dynamic-data">{{ $vendor->invoice_number }}</td>
                            <td class="dynamic-data">{{ $vendor->invoice_date }}</td>
                            <td class="dynamic-data">
                                @if($vendor->invoice_status == 'Paid')
                                    Invoiced
                                @elseif($vendor->invoice_status == 'Paid Record')
                                    Paid
                                @elseif($vendor->load_status == 'Completed')
                                    Completed
                                @elseif($vendor->load_status == 'Open')
                                    Open
                                @elseif($vendor->load_status == 'Unloading')
                                    Unloading
                                @else
                                    {{ $vendor->load_status }}
                                @endif
                            </td>
                            <td class="dynamic-data">{{ $vendor->created_at }}</td>
                            <td class="dynamic-data">{{ $vendor->user->name }}</td>
                            <td class="dynamic-data">
                                <input type="date" class="load_carrier_due_date" name="load_carrier_due_date" value="{{ $vendor->load_carrier_due_date }}" data-id="{{ $vendor->id }}">
                            </td>
                            <td class="dynamic-data">
                                <span class="formatted_date">{{ $vendor->load_carrier_due_date ? \Carbon\Carbon::parse($vendor->load_carrier_due_date)->format('d-m-Y') : '' }}</span>
                            </td>
                            <td class="dynamic-data">
                                <select style="width: 100%;" name="quick_pay" class="quick_pay" data-id="{{ $vendor->id }}">
                                    <option value="{{ $vendor->quick_pay }}">{{ $vendor->quick_pay ?? 'Please Select Quick Pay' }}</option>
                                    <option value="1%">1%</option>
                                    <option value="2%">2%</option>
                                    <option value="3%">3%</option>
                                    <option value="4%">4%</option>
                                    <option value="5%">5%</option>
                                    <option value="6%">6%</option>
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
                            <td>
                                @if($vendor->public_file)
                                    <li class="d-flex">
                                        @php
                                        // Define the path to the folder on the server
                                        $folderPath = storage_path('app/public/vendor_files/' . $vendor->id); // Adjust this to your folder path

                                        // Check if the folder exists
                                        if (file_exists($folderPath)) {
                                            // Get the folder creation time (metadata change time)
                                            $folderCreationTime = filectime($folderPath);

                                            // Format the folder creation time
                                            $folderCreationDate = date('Y-m-d H:i:s', $folderCreationTime); // Format the date
                                        } else {
                                            $folderCreationDate = 'Folder does not exist';
                                        }
                                        @endphp

                                        <a style="padding: 0; font-size: 14px; background-color: unset; border: unset;" 
                                            class="btn btn-primary text-white" 
                                            onclick="openModal({{ $vendor->id }})" 
                                            data-toggle="modal" 
                                            data-target="#view-file">
                                            <i class="fa fa-eye" style="margin-right: 10px;color: #212529;"></i>
                                        </a>

                                        <!-- Display Folder Creation Date -->
                                        <p style="margin: 7px 0;">Folder Created At: {{ $folderCreationDate }}</p>
                                    </li>
                                @else
                                    <li>
                                        <a style="padding: 0; font-size: 14px; background-color: unset; border: unset;" class="btn btn-primary text-white" href="javascript:void(0);" style="text-decoration:unset"> 
                                            <i class="fa fa-eye-slash" style="margin-right: 10px;color: red;"></i>
                                        </a>
                                    </li>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>
    <div class="modal" id="view-file">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Files</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="file-list" class="p-0"></ul>
                <!-- <button id="mergeButton" type="button" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> Merge
                    Documents</button> -->
            </div>
        </div>

    </div>
</div> 


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
            var dateInput = $(this); // Save reference to the input field

            $.ajax({
                url: '{{ route('update.load.date') }}', // Adjust this route as per your setup
                method: 'POST',
                data: {
                    id: id,
                    load_carrier_due_date: date
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Date updated successfully');
                        alert('Carrier Payment Date Selected successfully');

                        // Format the updated date to d-m-Y format and update the display
                        var formattedDate = new Date(date).toLocaleDateString('en-GB'); // Converts to d-m-Y format
                        dateInput.closest('td').next('td').find('.formatted_date').text(formattedDate);

                        // Leave the input field editable
                        // Removed code that disabled the input field
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
                // location.reload();
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
    function openModal(recordId) {
        $.ajax({
            url: '/get-files/' + recordId,
            method: 'GET',
            success: function (response) {
                var fileList = $('#file-list');
                fileList.empty();
                if (response.files && response.files.length > 0) {
                    $.each(response.files, function (index, file) {
                        var iframe = $('<iframe>', {
                            src: file,
                            frameborder: 0,
                            style: 'width: 100%; height: 300px; display: none;'
                        });
                        var listItem = $('<li>').append(iframe);

                        var toggleButton = $('<button>', {
                            text: 'Document File ' + (index + 1),
                            click: function () {
                                iframe.toggle();
                            }
                        });

                        fileList.append(toggleButton).append(listItem);
                    });
                } else {
                    fileList.append('<li>No documents have been uploaded.</li>');
                }

                // Add merge button functionality
                $('#mergeButton').off('click').on('click', function () {
                    mergeFiles(recordId); // Pass recordId to mergeFiles function
                });

                // // Show the modal
                // $('#view-file').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error fetching files:', xhr.responseText);
            }
        });
    }

    function mergeFiles(recordId) {
        $.ajax({
            url: '/merge-files',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                recordId: recordId // Pass recordId as data
            },
            success: function (response) {
                if (response.success) {
                    alert('Files merged successfully!');
                    // Open the merged PDF file in a new tab
                    var newTab = window.open(response.url, '_blank');
                    newTab.focus(); // Focus on the new tab
                } else {
                    alert('Failed to merge files: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error merging files:', xhr.responseText);
                alert('Error merging files: ' + xhr.responseText);
            }
        });
    }
</script>


<script>
    function openUploadWindow(url) {
        // Define the size of the new window
        var width = 1500;   // Width of the new window
        var height = 800;  // Height of the new window

        // Calculate the position to center the window
        var left = screen.width / 2 - width / 2;   // Center horizontally
        var top = screen.height / 2 - height / 2;  // Center vertically

        // Open the new window with the specified URL and properties
        var newWindow = window.open(url, 'UploadWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
        
        // Focus on the new window, if it was successfully opened
        if (newWindow) {
            newWindow.focus();
        }
    }
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
                    .columns(1)
                    .search(this.value)
                    .draw();
            });
        });
    });
</script>
@endsection