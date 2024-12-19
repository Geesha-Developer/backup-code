<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CARGO CONVOY CRM</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="./resources/css/app.css">
    <link rel="stylesheet" type="text/css"
        href="https://www.prepbootstrap.com/Content/shieldui-lite/dist/css/light/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/broker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<style>
    label {
        font-weight: 500;
        font-family: inherit;
    }

    .modal-backdrop.show {
        opacity: 0;
    }

    ul.navbar-nav.ms-auto {
        gap: 5px;
    }

    a.nav-link {
        border: unset;
        margin: 15px 0 0 40px;
        border-radius: 50px;
        background-color: #0d6efd;
        color: #fff;
    }

    /* li.nav-item {
    background-color: #0d6efd;
    border-radius: 15px;
} */
    .navbar-light .navbar-nav .nav-link {
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link:focus,
    .navbar-light .navbar-nav .nav-link:hover {
        color: #fff;
    }

    img#profile {
        height: 40px;
        width: auto;
    }

    form {
        padding: 10rem 0 0 0;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        color: var(--bs-body-color);
        appearance: none;
        background-color: var(--bs-body-bg);
        background-clip: padding-box;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: var(--bs-border-radius);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    input#email {
        border: 1px solid #00000038;
    }

    input#password {
        border: 1px solid #00000038;
    }



    .copyright {
        font-size: 17px;
        color:#fff;
        margin-top: 12px;
    }



    @media screen and (max-width: 768px) {

        .nav-item a.nav-link {
            font-size: 19px;
        }
    }
/* login button hover start */


.nav .fas{
    margin-right: 10px;
}
.nav .fa{
    margin-right: 10px;  
}
.nav li a {
    background: #1D2531;
    color: #fff;
    padding: 10px 20px;
    margin: 0px 10px;
    border-radius: 28px;
    text-decoration: none;
    font-size: 18px;
    border: 2px solid #fff;
}
.nav li a:hover {
    background: #62830b !important;
}
.nav{
    margin-top: 40px;
}
/* login button hover end */
</style>

<body
    style="background-image: url('{{ asset('backg.jpg') }}'); background-repeat: no-repeat; background-size: cover; width:100%;height: 100vh;">
    <!-- <body>     -->
    <div id="app">

        <div class="container">
            <div class="row d-flex justify-content-end">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="{{ route('account.login') }}"><i class="fa fa-book-reader"></i>Account</a>
                    </li> 
                    
                    <li class="nav-item">
                        <a href="{{ route('SuperAdminLogin') }}"><i class="fas fa-user-alt"></i>Admin</a>
                    </li>
                </ul>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            document.onreadystatechange = function () {
                var state = document.readyState;
                if (state == 'interactive') {
                    document.getElementById('loader').style.display = "block";
                } else if (state == 'complete') {
                    setTimeout(function () {
                        document.getElementById('loader').style.display = "none";
                    }, 1000);
                }
            };
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
        <!-- <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                adjustPageSize();
            });

            function adjustPageSize() {
                document.body.style.zoom = "70%";
            }
        </script> -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<div class="text-center copyright">
    <?php
 $date =  date('Y');
?>
    &#169;Copyright <?php echo $date ?> by <a href="https://geeshasolutions.com/">Geesha Solutions PVT LTD</a>

</div>

</html>