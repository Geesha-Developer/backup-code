<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta http-equiv="refresh" content="2"> -->
    <title>:: CCI Accounts Pannel</title>
    <link rel="icon" href="{{ asset('fav.jpg') }}" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/charts-c3/plugin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/morrisjs/morris.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/account.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<style>
     .profile-picture-container {
    border-radius: 110px;
}
    .alert {
    transition: opacity 0.5s ease-out; / Smooth transition for opacity /
    opacity: 1; / Ensure the element is fully visible initially /
}

.alert.fade-out {
    opacity: 0; / Set the element to be fully transparent /
}
ul.dropdown-menu.info.show {
    right: 0 !important;
}
.sidebar .user-info {
    top: 40px;
}
.dataTables_filter {
    right: 148px;
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
        <div class="navbar-brand">
        </div>
        <div class="menu">
            <div class="user-info">
                <a class="text-center" href="{{ route('admin.dashboard') }}"><img src="{{ asset('fav.jpg') }}"
                        alt="User"></a>
                <div class="detail">
                    @php
                    $adminUserData = session('admin_data', []);
                    @endphp

                    @if($adminUserData)
                    @foreach($adminUserData as $adminData)
                    <h4>{{ $adminData->name }}</h4>
                    @endforeach
                    @endif
                    <p> Accounts Admin</P>
                </div>
            </div>
            <ul class="list" style="padding: 0 11px; margin: 54px 0;">
                <li class="menu {{ request()->routeIs('accounts.admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('accounts.admin.dashboard') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/dashboard-control.png') }}" width="25">
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu {{ request()->routeIs('accounts') ? 'active' : '' }}">
                    <a href="{{ route('accounts') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/registration.png') }}" width="25">
                        <span>Accounting</span>
                    </a>
                </li>

                <li class="menu {{ request()->routeIs('carrier.customers.alldetail') ? 'active' : '' }}">
                    <a href="{{ route('carrier.customers.alldetail') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/team.png') }}" width="25">
                        <span>Address</span>
                    </a>
                </li>

                <li class="menu {{ request()->routeIs('accounts.broker.status') ? 'active' : '' }}">
                    <a href="{{ route('accounts.broker.status') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/team.png') }}" width="25">
                        <span>A/C Manager</span>
                    </a>
                </li>



                <li class="menu {{ request()->routeIs('accounts.manager.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('accounts.manager.dashboard') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/report.png') }}" width="25">
                        <span>Reporting</span>
                    </a>
                </li>

                <li class="menu {{ request()->routeIs('vendor.management') ? 'active' : '' }}">
                    <a href="{{ route('vendor.management') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/frontal-truck.png') }}" width="25">
                        <span>Vendor System</span>
                    </a>
                </li>

                <li class="menu {{ request()->routeIs('compliance') ? 'active' : '' }}">
                    <a href="{{ route('compliance') }}">
                        <img src="{{ asset('assets/images/sidebar-icons/compliance.png') }}" width="25">
                        <span>Compliance</span>
                    </a>
                </li>

                <!-- <li class="menu">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ asset('assets/images/sidebar-icons/logout.png') }}" width="25">
                        <span>Logout</span>
                    </a>
                </li> -->

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>

        </div>
    </aside>
    <div class="profile-notification">
        <ul class="d-flex p-0">
            <li>
             <i class="zmdi zmdi-eye toggleBlurButton"></i>
            </li>
            <li>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle p-0 m-0" data-toggle="dropdown">
                    <i class="zmdi zmdi-settings"></i>
                    </button>
                    <ul class="dropdown-menu info" role="menu">
                        <li><a class="text-white" href="#"><i
                                    style="background:unset;color:#fff; margin-top:0;"
                                    class="mr-2 zmdi zmdi-account-circle"></i>Profile</a></li>
                        <li><a class="text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Sign Out"><i
                                    style="background:unset;color:#fff; margin-top:0;" class="mr-2 zmdi zmdi-power"></i>Log Out</a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>


    @yield('content')

    <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> 
    <script src="{{ asset('assets/bundles/sparkline.bundle.js') }}"></script> 
    <script src="{{ asset('ssets/bundles/c3.bundle.js') }}"></script>

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}"></script>


    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script> 
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script> 

    <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('assets/js/pages/blog/blog.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.10.1/dist/chart.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!-- this script for Approval button chnage event when admin approve the case and its show another button using customer id  -->
    <script>
        function approveCustomer(customerId) {
            // Make an AJAX request to the Laravel route
            axios.put(`/approve-customer/${customerId}`)
                .then(response => {
                    const button = document.getElementById(`approveBtn_${customerId}`);
                    button.textContent = 'Approved';
                    button.className = 'btn btn-success btn-sm';
                    button.disabled = true;

                    alert(response.data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to approve customer.');
                });
        }
    </script>

    <!-- this script for delete customer by id using js  -->
    <script>
        function deleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                fetch(`/customer-delete/${customerId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = window.location.href;
                        } else {
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

    <script>
        $(function () {
            $('#div_refresh').load();
            setInterval(function () {
                $('#div_refresh').load(location.href + ' #div_refresh');
            }, 5000);
        });
    </script>

    <script>
        function markAsPaid(loadId) {
            axios.post(`/update-invoice-status/${loadId}`, {
                    status: 'Paid'
                })
                .then(response => {
                    const button = document.getElementById(`markAsPaidBtn_${loadId}`);
                    button.textContent = 'Paid';
                    button.className = 'btn btn-success btn-sm';
                    button.disabled = true;

                    alert(response.data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to mark as Paid.');
                });
        }
    </script>
    <script>
        function markAsPaid(loadId) {
            if (confirm('By Continuing, an Invoice Number Will be assigned to this Load. Are You sure to Continue')) {
                axios.post(`/update-invoice-status/${loadId}`, {
                        status: 'Paid'
                    })
                    .then(response => {
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
                axios.post(`/update-invoice-status-as-completed/${loadId}`, {
                        status: 'Completed'
                    })
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
        function markAsPaidRecord(loadId) {
            console.log('Inside markAsPaidRecord function');

            if (confirm('Are you sure you want to mark this as Paid ?')) {
                axios.post(`/update-invoice-status-as-paid-record/${loadId}`, {
                        status: 'Paid Record',
                        _token: '{{ csrf_token() }}'
                    })
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Paid Record:', error);
                        alert('Failed to mark as Paid Record.');
                    });
            }
        }
    </script>


    <script>
        function openLoad(loadId) {
            if (confirm('Are you sure you want to mark this as Open?')) {
                axios.put(`/update-load-status-as-open/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload(); // Reload the page after successful update
                    })
                    .catch(error => {
                        console.error('Error marking as Open:', error);
                        alert('Failed to mark as Open.');
                    });
            }
        }
    </script>


    <script>
        function markAsBackDeliveredRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Delivered?')) {
                axios.put(`/update-invoice-status-as-back-delivered/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload(); // Reload the page after successful update
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Deliver:', error);
                        alert('Failed to back in deliver.');
                    });
            }
        }
    </script>

    <script>
        function markAsBackCompleteRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Complete')) {
                axios.post(`/update-invoice-status-as-back-complete/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Complete:', error);
                        alert('Failed back in deliver.');
                    });
            }
        }
    </script>

    <script>
        function markAsBackInvoiceRecord(loadId) {
            if (confirm('Are you sure you want to back this record in Invoice?')) {
                axios.post(`/update-invoice-status-as-back-invoice/${loadId}`)
                    .then(response => {
                        console.log('AJAX request successful:', response);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error marking as Back to Invoice:', error);
                        alert('Failed back in Invoice.');
                    });
            }
        }
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
    <script>
        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            $('#dataTable').DataTable({
                pageLength: -1,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                columnDefs: [{
                    type: 'datetime',
                    targets: []
                }]
            });
        });
    </script>


     <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lastActiveTab = localStorage.getItem('lastActiveTab');
            if (lastActiveTab) {
                $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
            }
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var targetTab = e.target.getAttribute('href');
                localStorage.setItem('lastActiveTab', targetTab);
            });
            $('#dataTableOpen').DataTable();
            $('#dataTableDelivered').DataTable();
        });
    </script> 

    <script>
        document.getElementById('registrationForm').addEventListener('submit', function (event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                document.getElementById('passwordError').style.display = 'block';
            } else {
                document.getElementById('passwordError').style.display = 'none';
            }
        });
    </script>


<script>
$(document).ready(function () {
    var tables = $('.custom-table').DataTable({
        dom: 'Bfrtip',
        pageLength: 100,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    $('.filter-dropdown').on('change', function () {
        filterTables();
    });

    function filterTables() {
        var teamLead = $('.team_lead_filter').val();
        var manager = $('.manager_filter').val();
        var office = $('.office_filter').val();
        var startDate = $('.start_filter').val();
        var endDate = $('.end_filter').val();

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            var min = new Date(startDate).getTime();
            var max = new Date(endDate).getTime();
            var date = new Date(data[8]).getTime(); // Assuming 'Load Create Date' is in the 9th column (index 8)

            if ((isNaN(min) && isNaN(max)) ||
                (isNaN(min) && date <= max) ||
                (min <= date && isNaN(max)) ||
                (min <= date && date <= max)) {
                return true;
            }
            return false;
        });

        $('.custom-table').each(function () {
            var table = $(this).DataTable();
            table.column(5).search(manager).draw();
            table.column(6).search(teamLead).draw();
            table.column(4).search(office).draw();
            table.draw(); // Ensure the table is redrawn after applying filters
        });

        // Remove date filter after applying
        $.fn.dataTable.ext.search.pop();
    }
});

</script>

<script>
    // public/js/autorefresh.js

// Function to fetch data and update table
function fetchDataAndUpdateTable() {
    fetch('/data') // Fetch data from Laravel route
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementsByClassName('table-hover');
            tableBody.innerHTML = ''; // Clear previous table rows

            data.forEach(item => {
                // Create a new row
                const row = tableBody.insertRow();

                // Insert cells into the row
                const cell1 = row.insertCell(0);
                cell1.textContent = item.id;

                const cell2 = row.insertCell(1);
                cell2.textContent = item.name;

                // Add more cells as needed for additional data
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Initial data load
fetchDataAndUpdateTable();

// Auto-refresh every 5 seconds (adjust as needed)
setInterval(fetchDataAndUpdateTable, 5000); // 5000 milliseconds = 5 seconds

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
</body>

</html>