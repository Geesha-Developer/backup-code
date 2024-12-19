@extends('layouts.broker.app')
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
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
           <h2>Add Profile</h2>
        </div>

        <div class="container-fluid">

            <!-- Multi Column -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2>Insert Broker Profile</h2>
                        </div>
                        <div class="body">
                           <form method="POST" action="{{ route('profile.add') }}">
                                @csrf
                                <div class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_code">Employee Code:</label>
                                            <input type="text" class="form-control" name="employee_code">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_bio">Employee Bio:</label>
                                            <textarea class="form-control" name="employee_bio" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_mobile">Employee Mobile:</label>
                                            <input type="text" class="form-control" name="employee_mobile">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_facebook">Employee Facebook:</label>
                                            <input type="text" class="form-control" name="employee_facebook">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_linkedin">Employee LinkedIn:</label>
                                            <input type="text" class="form-control" name="employee_linkedin">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary" type="submit">Add Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
