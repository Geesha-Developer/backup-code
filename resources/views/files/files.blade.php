@extends('layouts.broker.app')
@section('content')
<style>
    .upload-document {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        padding: 17px;
        border-radius: 10px;
        margin-bottom: 30px;
    }



    .upload-document h6 {
        text-align: center;
        font-size: larger;
        margin: 11px 0;
    }

    @media (min-width: 576px) {
        select.form-control,
        input#customer_city,
        input#customer_zip,
        input.form-control {
            height: 40px !important;
            font-size: 13px;
        }
    }

    .form-control {
        border: unset;
    }

    .newbtn {
        cursor: pointer;
        width: 100%;
        text-align: center;
        border: 1px dashed #5a770d;
        padding: 2px 0;
        border-radius: 10px;
    }

    .upload-document ul li {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        padding: 0 7px;
        list-style: none;
        margin-bottom: 16px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
    }

    .upload-document ul {
        padding-inline-start: 0;
    }

    .form-label {
        font-size: 12px;
    }
</style>

<section class="content">
    <div class="block-header" style="padding: 16px 15px !important">
        <h2>Upload Files</h2>
    </div>
    <div class="upload-document">
        @if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa fa-check"></i>
  <h4 class="alert-heading"><b>Well done!</b></h4>
  <p>Your Load Has been Created Successfully!</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <button type="button" class="btn btn-success" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="fa fa-warning"></i>
  <h4 class="alert-heading"><b>Error!</b></h4>
  <p>{{ session('error') }}</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <button type="button" class="btn btn-danger" onclick="$('.alert').alert('close');">OK</button>
</div>
@endif

        <form class="mb-4" action="{{ route('files.upload.post', ['filesId' => $load->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="">
                <h6 class="mb-2 text-left" style="font-size: 15px;"><b>Load Number: {{ $load->load_number }}</b></h6>
               <div class="table-responsive">
               <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Upload / Existing Files</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Carrier Rate Confirmation -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Carrier Rate Confirmation</b></td>
                            <td style="padding: 0 10px;">
                                <!-- File upload field -->
                                <input class="form-control form-control-lg" name="carrer_rate_cnfrm_doc" id="carrer_rate_cnfrm_doc" type="file" onchange="previewFile(this, 'preview_carrer_rate_cnfrm_doc')">
                            </td>
                           
                            <td style="padding: 0 10px;" class="d-flex justify-content-center">
                            @if (!empty($uploadedFiles['carrer_rate_cnfrm_doc']))
                                @foreach ($uploadedFiles['carrer_rate_cnfrm_doc'] as $subFile)
                                    <a href="{{ asset('storage/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"> </a>
                                @endforeach
                            @endif

                            <!-- Preview selected file -->
                            <div id="preview_carrer_rate_cnfrm_doc"></div>

                            <!-- Delete button for existing file -->
                            @if (!empty($uploadedFiles['carrer_rate_cnfrm_doc']))
                                <button class="delete-file btn fa fa-trash mt-2" data-key="carrer_rate_cnfrm_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
                                </button>
                            @endif

                            </td>
                        </tr>

                        <!-- Pod -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Pod</b></td>
                            <td style="padding: 0 10px;">
                                <input class="form-control form-control-lg" name="pod_doc" id="pod_doc" type="file" onchange="previewFile(this, 'preview_pod_doc')">
                            </td>
                           
                            <td style="padding: 0 10px;">
                            @if (!empty($uploadedFiles['pod_doc']))
                                    @foreach ($uploadedFiles['pod_doc'] as $subFile)
                                        <a href="{{ asset('storage/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
                                    @endforeach
                                @endif
                                <div id="preview_pod_doc"></div>
                                @if (!empty($uploadedFiles['pod_doc']))
                                    <button class="delete-file btn fa fa-trash mt-2" data-key="pod_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Shipper Rate Approval -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Shipper Rate Approval (Screen Shot)</b></td>
                            <td style="padding: 0 10px;">
                                <input class="form-control form-control-lg" name="shipper_rate_approval_doc" id="shipper_rate_approval_doc" type="file" onchange="previewFile(this, 'preview_shipper_rate_approval_doc')">
                            </td>
                           
                            <td style="padding: 0 10px;">
                            @if (!empty($uploadedFiles['shipper_rate_approval_doc']))
                                    @foreach ($uploadedFiles['shipper_rate_approval_doc'] as $subFile)
                                        <a href="{{ asset('storage/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
                                    @endforeach
                                @endif
                                <div id="preview_shipper_rate_approval_doc"></div>
                                @if (!empty($uploadedFiles['shipper_rate_approval_doc']))
                                    <button class="delete-file btn fa fa-trash mt-2" data-key="shipper_rate_approval_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Carrier Invoice -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Carrier Invoice</b></td>
                            <td style="padding: 0 10px;">
                                <input class="form-control form-control-lg" name="carrier_invoice_doc" id="carrier_invoice_doc" type="file" onchange="previewFile(this, 'preview_carrier_invoice_doc')">
                            </td>
                            
                            <td style="padding: 0 10px;">
                            @if (!empty($uploadedFiles['carrier_invoice_doc']))
                                    @foreach ($uploadedFiles['carrier_invoice_doc'] as $subFile)
                                        <a href="{{ asset('storage/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
                                    @endforeach
                                @endif
                                <div id="preview_carrier_invoice_doc"></div>
                                @if (!empty($uploadedFiles['carrier_invoice_doc']))
                                    <button class="delete-file btn fa fa-trash mt-2" data-key="carrier_invoice_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Delivery Order -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Delivery Order</b></td>
                            <td style="padding: 0 10px;">
                                <input class="form-control form-control-lg" type="file" readonly name="DO">
                            </td>
                            
                            <td style="padding: 0 10px;">
                            @if (!empty($uploadedFiles['DO']))
                                    @foreach ($uploadedFiles['DO'] as $subFile)
                                        <a href="{{ asset('storage/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
                                    @endforeach
                                @endif
                                <div id="preview_DO"></div>
                                @if (!empty($uploadedFiles['DO']))
                                    <button class="delete-file btn fa fa-trash mt-2" data-key="DO" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Optional Documents Section -->
                        <tr>
                            <td style="padding: 0 10px;"><b>Optional Documents</b></td>
                            <td style="padding: 0 10px;">
                                <input class="form-control form-control-lg" name="optional_docs[]" id="optional_docs" type="file" multiple onchange="previewMultipleFiles(this, 'preview_optional_docs')">
                            </td>
                            <td style="padding: 0 10px;">
                                <div id="preview_optional_docs"></div>
                            </td>
                        </tr>

                    </tbody>
                </table>
               </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-info" style="padding: 5px 19px;">Save</button>
                </div>
            </div>
        </form>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-file').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var fileKey = button.data('key');
            var filePath = button.data('file');
            var recordId = button.data('record-id');

            if (confirm('Are you sure you want to delete this file?')) {
                $.ajax({
                    url: '{{ route('delete.file.broker') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        record_id: recordId,
                        file_name: filePath
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('li').remove();
                        } else {
                            alert('Failed to delete the file.');
                        }
                    },
                    error: function(response) {
                        alert('An error occurred while trying to delete the file.');
                    }
                });
                location.reload();
            }
        });
    });
</script>

<script>
// Function to convert bytes to a readable format (KB, MB)
function formatSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
    else if (bytes < 1073741824) return (bytes / 1048576).toFixed(2) + ' MB';
    else return (bytes / 1073741824).toFixed(2) + ' GB';
}

// Preview selected file
function previewFile(input, previewId) {
    var preview = document.getElementById(previewId);
    preview.innerHTML = "";  // Clear previous preview

    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileType = file.type;
        var fileSize = formatSize(file.size);  // Get the readable file size

        // Display file size
        var sizeDisplay = document.createElement('p');
        sizeDisplay.innerText = 'Size: ' + fileSize;
        preview.appendChild(sizeDisplay);

        if (fileType.startsWith('image/')) {
            // Display image preview
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else if (fileType === 'application/pdf') {
            // Display PDF icon
            var icon = document.createElement('i');
            icon.className = 'fa fa-file-pdf-o text-danger';
            var pdfLink = document.createElement('a');
            pdfLink.href = URL.createObjectURL(file);
            pdfLink.target = '_blank';
            pdfLink.appendChild(icon);
            preview.appendChild(pdfLink);
        } else {
            // Display a generic file icon
            var icon = document.createElement('i');
            icon.className = 'fa fa-file-o';
            preview.appendChild(icon);
        }
    }
}

// Preview multiple files (optional documents)
function previewMultipleFiles(input, previewId) {
    var preview = document.getElementById(previewId);
    preview.innerHTML = "";  // Clear previous previews

    if (input.files) {
        Array.from(input.files).forEach(function(file) {
            var fileType = file.type;
            var fileSize = formatSize(file.size);  // Get the readable file size

            // Display file size
            var sizeDisplay = document.createElement('p');
            sizeDisplay.innerText = 'Size: ' + fileSize;
            preview.appendChild(sizeDisplay);

            if (fileType.startsWith('image/')) {
                // Display image preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '200px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                // Display PDF icon
                var icon = document.createElement('i');
                icon.className = 'fa fa-file-pdf-o text-danger';
                var pdfLink = document.createElement('a');
                pdfLink.href = URL.createObjectURL(file);
                pdfLink.target = '_blank';
                pdfLink.appendChild(icon);
                preview.appendChild(pdfLink);
            } else {
                // Display a generic file icon
                var icon = document.createElement('i');
                icon.className = 'fa fa-file-o';
                preview.appendChild(icon);
            }
        });
    }
}
</script>


@endsection
