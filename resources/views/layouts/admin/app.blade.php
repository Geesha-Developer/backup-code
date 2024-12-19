<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>:: CCI Super Admin Pannel (Admin)</title>
    <link rel="icon" href="{{ asset('fav.jpg') }}" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/charts-c3/plugin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="...">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/zurb-material-icons@3.7.5/zurb-material-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">



</head>
<style>
   .profile-picture-container {
    border-radius: 110px;

}
.collapse.show {
    background-color: #1d2531;
    border-radius: 10px;
}
.collapse.show a{
    margin: 10px 10px;
}
.collapse.show a:hover{
    background: #fff;
    color: #27310c;
    margin: 10px 10px;
    border-radius: 10px;
}

.btn-warning {
    background: none !important;
    border: none !important;
}
.alert {
    transition: opacity 0.5s ease-out; /* Smooth transition for opacity */
    opacity: 1; /* Ensure the element is fully visible initially */
}

.alert.fade-out {
    opacity: 0; /* Set the element to be fully transparent */
}
ul.dropdown-menu.info.show {
    right: 0 !important;
}
.notification-bell {
            position: relative;
            cursor: pointer;
            color: #333;
        }
        .notification-bell .count-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .notification-bell i {
            font-size: 24px;
            animation: ring 1.5s ease infinite;
        }
        @keyframes ring {
            0% { transform: rotate(0); }
            10% { transform: rotate(15deg); }
            20% { transform: rotate(-10deg); }
            30% { transform: rotate(5deg); }
            40% { transform: rotate(-5deg); }
            50% { transform: rotate(0); }
            100% { transform: rotate(0); }
        }

        /* Dropdown Drawer Styling */
        .notification-drawer {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            width: 250px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
        }
        .notification-drawer.open {
            display: block;
        }
        .notification-drawer-header {
            padding: 10px;
            background-color: #0dcaf0;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        .notification-drawer-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .notification-drawer-list li {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .notification-drawer-list li:last-child {
            border-bottom: none;
        }
        .notification-drawer-list a {
            text-decoration: none;
            color: #333;
        }
        .btn-group .dropdown-menu hr{
        border: 1px solid #fff;
        margin: 0;
        }
        .btn-group span.count-badge {
    position: absolute;
    background: #ff2c2c;
    border-radius: 30px;
    font-size: 12px;
    padding: 1px 3px;
    left: 37px;
    top: -8px;
    color: #fff;
}
</style>

<body class="theme-blush">

    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{ asset('assets/images/loader.svg') }}" width="48" height="48" alt="Aero"></div>
        <p>Please wait...</p>
    </div>
</div> -->
@php
    use App\Models\customer;
    $newCustomerCount = customer::count();
    $latestCustomers = customer::get();
@endphp
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Main Search -->
    <div id="search">
        <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
        <form>
            <input type="search" value="" placeholder="Search..." />
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>


    <button class="btn-menu ls-toggle-btn" id="menu-btn" onclick="toggleMenu()" type="button"><i class="zmdi zmdi-menu" style="font-size: 23px;"></i></button>
    <!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="user-info">
        <a href="{{ route('all.load.status') }}" class="text-center">
            <img src="{{ asset('images/only logo.png') }}" width="35%" alt="Aero" />
        </a>
        <div class="detail text-center m-0 admin_name">
            <small>Super Admin</small>
        </div>
    </div>
    <div class="menu">
        <ul class="list" style="padding: 0 11px; margin: 54px 0;">
            <li class="menu {{ request()->routeIs('all.load.status') ? 'active' : '' }}">
                <a href="{{ route('all.load.status') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/home-side.png') }}" width="25">
                    <span>Home</span>
                </a>
            </li>
            <!-- <li class="menu {{ request()->routeIs('user.register.form') ? 'active' : '' }}">
                <a href="{{ route('user.register.form') }}" target="_blank">
                    <img src="{{ asset('assets/images/sidebar-icons/registration.png') }}" width="25">
                    <span>Add New User</span>
                </a>
            </li> -->
            <li class="menu {{ request()->routeIs('broker_data') ? 'active' : '' }}">
                <a href="javascript:void(0);" id="brokerDataMenu">
                    <img src="{{ asset('assets/images/sidebar-icons/customer-service.png') }}" width="25">
                    <span>All Data</span>
                </a>
                <div class="modal" id="pinInputContainer">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 style="font-size: 16px; text-align: left; font-weight: 700; font-family: 'Poppins';">Enter PIN</h4>
                                <button type="button" class="close close-modal-btn" data-dismiss="modal" style="right: 32px;top: 30px !important;">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="pinInput" autocomplete="off" placeholder="Enter PIN" style="width: 80%; padding: 5px; margin-right: 5px;">
                                    <button id="verifyPinBtn" class="btn btn-info" style="margin: 0; padding: 0 10px; color: #fff;">Verify</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="pinInputContainer" style="display: none; margin-top: 10px;">
                    <input type="text" id="pinInput" placeholder="Enter PIN" style="width: 80%; padding: 5px; margin-right: 5px;">
                    <button id="verifyPinBtn" style="padding: 5px 10px;">Verify</button>
                </div> -->
            </li>
            <div id="accordion">
                <li class="menu">
                    <a data-toggle="collapse" href="#collapseOne" class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/sidebar-icons/administrator.png') }}" width="25">
                        <span style="margin-left: 17px;">Admin</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                        <a href="{{ route('user.register.form') }}" target="_blank"><span>Add New User</span></a>
                        <a href="{{ route('add.leader') }}"><span>Add Leader</span></a>
                        <a href="{{ route('accounts.create.new.login') }}"><span>Create A/C</span></a>
                        <a href="{{ route('office.added') }}"><span>Add Office</span></a>
                    </div>
                </li>
                <li class="menu">
                    <a data-toggle="collapse" data-toggle="collapse" href="#collapseTwo" class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/sidebar-icons/multiple-users-silhouette.png') }}" width="25">
                        <span style="margin-left: 17px;">User</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <a href="{{ route('all.users') }}"><span>User List</span></a>
                        <a href="{{ route('accountuser') }}"><span>A/C User</span></a>
                    </div>
                </li>
            </div>

            <li class="menu {{ request()->routeIs('its.data') ? 'active' : '' }}">
                <a href="{{ route('its.data') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/customer-service.png') }}" width="25">
                    <span>ITS Data</span>
                </a>
            </li>
            <!-- <li class="menu {{ request()->routeIs('office.added') ? 'active' : '' }}">
                <a href="{{ route('office.added') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/office-add.png') }}" width="25">
                    <span>Add Office</span>
                </a>
            </li>
            <li class="menu {{ request()->routeIs('add.leader') ? 'active' : '' }}">
                <a href="{{ route('add.leader') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/leader.png') }}" width="25">
                    <span>Add Leader</span>
                </a>
            </li> -->
            <li class="menu {{ request()->routeIs('accounts.supper.admin') ? 'active' : '' }}">
                <a href="{{ route('accounts.supper.admin') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/account.png') }}" width="25">
                    <span>Accounts</span>
                </a>
            </li>
            <li class="menu {{ request()->routeIs('admin.broker.status') ? 'active' : '' }}">
                <a href="{{ route('admin.broker.status') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/account-manager.png') }}" width="25">
                    <span>A/C Manager</span>
                </a>
            </li>
            <li class="menu {{ request()->routeIs('admin.manager.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.manager.dashboard') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/reporting.png') }}" width="25">
                    <span>Reporting</span>
                </a>
            </li>
            <li class="menu {{ request()->routeIs('admin.vendor') ? 'active' : '' }}">
                <a href="{{ route('admin.vendor') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/frontal-truck.png') }}" width="25">
                    <span>Vendor System</span>
                </a>
            </li>
            <li class="menu {{ request()->routeIs('admin.compliance') ? 'active' : '' }}">
                <a href="{{ route('admin.compliance') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/compliance.png') }}" width="25">
                    <span>Compliance</span>
                </a>
            </li>
            <!-- <li class="menu {{ request()->routeIs('all.users') ? 'active' : '' }}">
                <a href="{{ route('all.users') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/user-list.png') }}" width="25">
                    <span>User List</span>
                </a>
            </li> -->
            <!-- <li class="menu {{ request()->routeIs('accounts.create.new.login') ? 'active' : '' }}">
                <a href="{{ route('accounts.create.new.login') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/report.png') }}" width="25">
                    <span>Create A/C</span>
                </a>
            </li> -->
            <!-- <li class="menu {{ request()->routeIs('accountuser') ? 'active' : '' }}">
                <a href="{{ route('accountuser') }}">
                    <img src="{{ asset('assets/images/sidebar-icons/report.png') }}" width="25">
                    <span>A/C User</span>
                </a>
            </li> -->
            <!-- <li class="menu {{ request()->routeIs('Super.Admin.Logout') ? 'active' : '' }}">
                <a href="{{ route('Super.Admin.Logout') }}" class="mega-menu" title="Sign Out">
                    <i class="zmdi zmdi-power"></i>
                    <span>Logout</span>
                </a>
            </li> -->
            
        </ul>
    </div>
</aside>
<div class="profile-notification">
            <ul class="d-flex">
            <li>
                <div class="btn-group">
                    <button class="dropdown-toggle p-0 m-0" data-toggle="dropdown" style="background: unset;border: unset;">
                    <i class="zmdi zmdi-notifications"></i>
                        @if ($newCustomerCount > 0)
                            <span class="count-badge">{{ $newCustomerCount }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu info" role="menu" style="min-width: 18rem !important;height: 370px;overflow-y: scroll;">
                        <div class="drop-title text-white text-center"><b>Notifications</b></div>
                        
                        <!-- Loop through latest customer notifications -->
                        @foreach ($latestCustomers as $customer)
                            <li>
                                <div class="notification-content">
                                <a href="{{ route('edit.customer', ['id' => $customer->id]) }}">{{ $customer->user->name }} added a new customer</p></a>
                                </div>
                            </li>
                            <hr>
                        @endforeach
                      
                    </ul>
                </div>
            </li>

                <li>
                <i class="zmdi zmdi-eye toggleBlurButton"></i>
                </li>
                <li>
                    <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle p-0 m-0" data-toggle="dropdown">
                        <i class="zmdi zmdi-settings"></i>
                        </button>
                        <ul class="dropdown-menu info" role="menu">
                            <li><a class="text-white" href="https://crmcargoconvoy.co/profile"><i style="background:unset;color:#fff; margin-top:0;" class="mr-2 zmdi zmdi-account-circle"></i>Profile</a></li>
                            <li><a class="text-white" href="{{ route('Super.Admin.Logout') }}" title="Sign Out"><i style="background:unset;color:#fff; margin-top:0;" class="mr-2 zmdi zmdi-power"></i>Log Out</a></li>

                        </ul>
                    </div>
                </li>
            </ul>
    </div>

    <!-- Right Sidebar -->
   
    <!-- Main Content -->
    @yield('content')

    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script> <!-- Sparkline Plugin Js -->
    <script src="{{ asset('ssets/bundles/c3.bundle.js') }}"></script>

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>


    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js -->

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script><!-- USA Map Js -->
    <script src="{{ asset('assets/js/pages/blog/blog.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.10.1/dist/chart.min.js"></script>


    <!-- New Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<!-- DataTables Buttons Print JS -->
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script>
        function approveCustomer(customerId) {
            // Make an AJAX request to the Laravel route
            axios.put(`/approve-customer/${customerId}`)
                .then(response => {
                    // Update the button text and disable it
                    const button = document.getElementById(`approveBtn_${customerId}`);
                    button.textContent = 'Approved';
                    button.className = 'btn btn-success btn-sm';
                    button.disabled = true;

                    alert(response.data.message); // You can show a success message if needed
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to approve customer.'); // Show an error message
                });
        }

    </script>

    <!-- this script for delete customer by id using js  -->
    <script>
        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                // Assuming you have a route for customer deletion
                fetch(`/customer-delete/${customerId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Redirect back to the same page after successful deletion
                            window.location.href = window.location.href;
                        } else {
                            // Handle error
                            console.error('Error deleting customer');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting customer', error);
                    });
            }
        }

    </script>



<!-- this script for delete carrier by id using js  -->
    <script>
        function deleteExternal(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                // Assuming you have a route for customer deletion
                fetch(`/carrier-delete/${customerId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })

                    .then(response => {
                        if (response.ok) {
                            // Redirect back to the same page after successful deletion
                            window.location.href = window.location.href;
                        } else {
                            // Handle error
                            console.error('Error deleting customer');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting customer', error);
                    });
            }
            console.log('deleteExternal function called with customerId:', customerId);

        }

    </script>

<!-- this script for enable customer  -->

    <script>
        function enableEditing() {
            // Enable all input fields for editing
            var inputs = document.querySelectorAll('input');
            inputs.forEach(function (input) {
                input.removeAttribute('disabled');
            });

            // Change the button to Save
            var saveButton = document.querySelector('button[type="submit"]');
            saveButton.innerText = 'Save Customer';
        }

    </script>

<!-- this script for resize the webpage size -->
<!-- <script>
  document.addEventListener("DOMContentLoaded", function(event) {
    adjustPageSize();
  });

  function adjustPageSize() {
    document.body.style.zoom = "80%";
  }
</script> -->
<script>
    $(function() {
        $('#div_refresh').load();
        setInterval(function() {
            $('#div_refresh').load(location.href + ' #div_refresh');
        }, 5000);
    });
</script>  

<script>
    function markAsPaid(loadId) {
        // Make an AJAX request to the Laravel route
        axios.post(`/update-invoice-status/${loadId}`, { status: 'Paid' })
            .then(response => {
                // Update the button text and disable it
                const button = document.getElementById(`markAsPaidBtn_${loadId}`);
                button.textContent = 'Paid';
                button.className = 'btn btn-success btn-sm';
                button.disabled = true;

                alert(response.data.message); // You can show a success message if needed
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to mark as Paid.'); // Show an error message
            });
    }
</script>
<script>
    function markAsPaid(loadId) {
        if (confirm('Are you sure you want to mark this as Paid?')) {
            // Assuming you are using axios for your AJAX requests
            axios.post(`/update-invoice-status/${loadId}`, { status: 'Paid' })
                .then(response => {
                    // Handle success, for example, reload the page
                    location.reload();
                })
                .catch(error => {
                    console.error('Error marking as Paid:', error);
                    alert('Failed to mark as Paid.');
                });
        }
    }
</script>


<script>
    function markAsCompleted(loadId) {
        console.log('Inside markAsCompleted function');

        if (confirm('Are you sure you want to mark this as Completed?')) {
            axios.post(`/update-invoice-status-as-completed/${loadId}`, { status: 'Completed' })
                .then(response => {
                    console.log('AJAX request successful:', response);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error marking as Completed:', error);
                    alert('Failed to mark as Completed.');
                });
        }
    }
</script>

<script>
    function markInvoiceAsPaid(loadId) {
        console.log('Inside markInvoiceAsPaid function');

        if (confirm('Are you sure you want to mark this as Paid?')) {
            axios.post(`/mark-invoice-as-paid/${loadId}`, { status: 'Paid' })
                .then(response => {
                    console.log('AJAX request successful:', response);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error marking as Paid:', error);
                    alert('Failed to mark as Paid.');
                });
        }
    }
</script>


<script>
$(document).ready(function () {
    $('#state').prop('disabled', true).html('<option value="" disabled selected>Choose States</option>');

    $('#country').change(function () {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                type: "GET",
                url: "{{ route('get.states.by.country') }}",
                data: {
                    'country_id': countryId
                },
                success: function (data) {
                    data.sort(function (a, b) {
                        return a.name.localeCompare(b.name);
                    });

                    $('#state').prop('disabled', false);

                    $('#state').empty();
                    $('#state').append('<option value="" disabled>Select State</option>');
                    $.each(data, function (key, value) {
                        $('#state').append('<option value="' + value.id + '">' + value
                            .name + '</option>');
                    });
                }
            });
        } else {
            // Disable and show "Select State" if no country is selected
            $('#state').prop('disabled', true).html('<option value="" disabled selected>Select State</option>');
        }
    });
});


</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            // Your Laravel Blade variables
            var labels = {
                !!json_encode($labels) !!
            };
            var datasets = {
                !!json_encode($datasets) !!
            };

            // Get the canvas element and context
            var ctx = document.getElementById('user_chart').getContext('2d');

            // Create the Chart instance
            var userChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets,
                },
            });
        });

    </script>

<script>
    function clearForm() {
        var form = document.getElementById("myForm");
        var elements = form.elements;

        for (var i = 0; i < elements.length; i++) {
            var elementType = elements[i].type.toLowerCase();
            switch (elementType) {
                case "text":
                case "select-one":
                    elements[i].value = "";
                    break;
                case "checkbox":
                    elements[i].checked = false;
                    break;
                default:
                    break;
            }
        }
    }

</script>
<script>
    // Use JavaScript to hide options with class 'hiddenOption'
    var hiddenOptions = document.getElementsByClassName('hiddenOption');
    for (var i = 0; i < hiddenOptions.length; i++) {
        hiddenOptions[i].style.display = 'none';
    }

</script>
<script>
    function showInput() {
        var customeInput = document.getElementById('custome_input');
        var customeOption = document.getElementById('custome');

        // Check if the "Custom" option is selected
        if (customeOption.selected) {
            customeInput.style.display = 'block';
        } else {
            customeInput.style.display = 'none';
        }
    }

</script>

<script>
        $(document).ready(function () {
            $('#same_as_physical').on('change', function () {
                if ($(this).is(':checked')) {
                    copyFieldValue('#customer_address', '#customer_billing_address');
                    copyFieldValue('#customer_city', '#customer_billing_city');
                    copyFieldValue('#customer_zip', '#customer_billing_zip');
                    var selectedCntry = $("#country option:selected").text();
                    $('#customer_billing_country').val(selectedCntry);

                    var selectedState = $("#state option:selected").text();
                    $('#customer_billing_state').val(selectedState);


                    // Disable corresponding billing fields
                    $('[id^="customer_billing_"]').prop('disabled', true);
                } else {
                    // Clear and enable corresponding billing fields
                    $('[id^="customer_billing_"]').val('').prop('disabled', false);
                }
            });

            // Function to copy field value
            function copyFieldValue(sourceId, targetId) {
                var sourceValue = $(sourceId).val();
                // var sourceValue = $(sourceId).data('name');
                $(targetId).val(sourceValue);
            }
        });
</script>

<script>
        $('#country').change(function () {
            var selectedValue = $("#country option:selected").text();
            if (selectedValue) {
                $('#customer_billing_country').val(selectedValue);
            }
        });

        $('#state').change(function () {
            var selectedValue = $("#state option:selected").text();
            if (selectedValue) {
                $('#customer_billing_state').val(selectedValue);

            }
        });
</script>


<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('.table')) {
            $('.table').DataTable().destroy();
        }

        $('.table').DataTable({
            pageLength: 50,
            dom: 'Bfrtip', 
            buttons: [
                'copy', 'excel', 'pdf', 'print','csv'
            ],
            columnDefs: [
                { type: 'datetime', targets: [] } 
            ]
        });
    });
</script>

<script>
    function toggleMenu() {
        var sidebar = document.getElementById('leftsidebar');
        var userInfo = sidebar.querySelector('.user-info');
        var activeItems = document.querySelectorAll('.theme-blush .sidebar .menu .list li.active');
        var contentSection = document.querySelector('section.content');

        // Check if the window width is below 768px (for mobile devices)
        var isMobile = window.innerWidth <= 768;

        // Toggle the sidebar's 'shrink' class
        sidebar.classList.toggle('shrink');

        // If the sidebar is shrinking (closing), hide elements and adjust layout
        if (sidebar.classList.contains('shrink') || isMobile) {
            userInfo.classList.add('hide');
            activeItems.forEach(item => {
                item.classList.add('no-border');
            });

            // Apply styles for the content section when sidebar is shrunk or on mobile
            contentSection.style.margin = '11px 0 20px 0';
        } else {
            // If the sidebar is not shrinking, show the user info and reset the active items
            userInfo.classList.remove('hide');
            activeItems.forEach(item => {
                item.classList.remove('no-border');
            });

            // Apply styles for the content section when the sidebar is expanded
            contentSection.style.margin = '11px 0 20px 207px';
        }
    }

    // Close the sidebar by default on mobile devices when the page loads
    window.addEventListener('load', function() {
        if (window.innerWidth <= 768) {
            var sidebar = document.getElementById('leftsidebar');
            sidebar.classList.add('shrink');  // Add the 'shrink' class to close the sidebar on mobile
        }
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            // Fade out success message
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.classList.add('fade-out');
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500); // Match the transition duration
            }

            // Fade out error message
            var errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                errorMessage.classList.add('fade-out');
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 500); // Match the transition duration
            }
        }, 2000); // 2000 milliseconds = 2 seconds
    });
</script>
<script>
    function toggleBlur() {
        var dynamicCells = document.querySelectorAll('.dynamic-data');
        dynamicCells.forEach(function (cell) {
            var blurValue = cell.style.filter === 'blur(5px)' ? 'none' : 'blur(5px)';
            cell.style.filter = blurValue;
        });
    }

    // Add event listeners to all buttons with the class 'toggleBlurButton'
    document.querySelectorAll('.toggleBlurButton').forEach(function (button) {
        button.addEventListener('click', function () {
            toggleBlur();
        });
    });
</script>
<script>
    $(document).ready(function () {
        // Automatically hide success alert after 2 seconds
        @if(session('success'))
            setTimeout(function () {
                $('#success-alert').alert('close');
            }, 2000);  // 2000ms = 2 seconds
        @endif

        // Automatically hide error alert after 2 seconds
        @if(session('error'))
            setTimeout(function () {
                $('#error-alert').alert('close');
            }, 2000);  // 2000ms = 2 seconds
        @endif
    });
</script>

<script>
        // Toggle Notification Drawer on Icon Click
        document.getElementById('notificationIcon').addEventListener('click', function() {
            const drawer = document.getElementById('notificationDrawer');
            drawer.classList.toggle('open');
        });

        // Close the drawer if clicked outside
        document.addEventListener('click', function(event) {
            const drawer = document.getElementById('notificationDrawer');
            const icon = document.getElementById('notificationIcon');
            if (!drawer.contains(event.target) && !icon.contains(event.target)) {
                drawer.classList.remove('open');
            }
        });
    </script>
    <script>
    $(document).ready(function () {
    var table = $('#example').DataTable();

    // Add an event listener to the search input
    $('#example_filter input[type="search"]').on('input', function () {
        if ($(this).val() === '') {
            table.search('').draw(); // Clear the search
        }
    });
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuItem = document.getElementById("brokerDataMenu");
        const pinInputContainer = document.getElementById("pinInputContainer");
        const pinInput = document.getElementById("pinInput");
        const verifyPinBtn = document.getElementById("verifyPinBtn");

        // Show PIN input when the menu is clicked
        menuItem.addEventListener("click", function () {
            pinInputContainer.style.display = "block";
        });

        // Handle PIN verification
        verifyPinBtn.addEventListener("click", function () {
            const enteredPin = pinInput.value;

            if (!enteredPin) {
                alert("Please enter a PIN.");
                return;
            }

            // Make an AJAX request to verify the PIN
            fetch('{{ route("broker_data") }}?otp=' + enteredPin)
                .then(response => {
                    if (response.status === 200) {
                        // Redirect to the broker_data page if PIN is verified
                        window.location.href = '{{ route("broker_data") }}?otp=' + enteredPin;
                    } else {
                        // Show error if PIN is not verified
                        return response.json().then(data => {
                            alert(data.error || "Invalid PIN. Please try again.");
                        });
                    }
                })
                .catch(error => {
                    console.error("Error verifying PIN:", error);
                    alert("Something went wrong. Please try again.");
                });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const menuItem = document.getElementById("brokerDataMenu");
        const pinInputContainer = document.getElementById("pinInputContainer");
        const pinInput = document.getElementById("pinInput");
        const verifyPinBtn = document.getElementById("verifyPinBtn");

        // Show PIN input when the menu is clicked
        menuItem.addEventListener("click", function () {
            pinInputContainer.style.display = "block";
        });

        // Handle PIN verification
        verifyPinBtn.addEventListener("click", function () {
            const enteredPin = pinInput.value;

            if (!enteredPin) {
                alert("Please enter a PIN.");
                return;
            }

            // Make an AJAX request to verify the PIN
            fetch('{{ route("broker_data") }}?otp=' + enteredPin)
                .then(response => {
                    if (response.status === 200) {
                        // Redirect to the broker_data page if PIN is verified
                        window.location.href = '{{ route("broker_data") }}?otp=' + enteredPin;
                    } else {
                        // Show error if PIN is not verified
                        return response.json().then(data => {
                            alert(data.error || "Invalid PIN. Please try again.");
                        });
                    }
                })
                .catch(error => {
                    console.error("Error verifying PIN:", error);
                    alert("Something went wrong. Please try again.");
                });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const closeModalBtn = document.querySelector(".close-modal-btn"); // Close button
        const pinInputContainer = document.getElementById("pinInputContainer"); // Modal container

        // Close the modal when the close button is clicked
        closeModalBtn.addEventListener("click", function () {
            pinInputContainer.style.display = "none"; // Hide the modal
        });
    });
</script>
</body>

</html>
