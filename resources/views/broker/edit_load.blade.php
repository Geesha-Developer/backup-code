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
<style>
    @media (min-width: 576px){
select.form-control, input#customer_city, input#customer_zip, input.form-control {
    height: 100% !important;
    font-size: 12px;
}
}
</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Form Examples</h2>
        </div>

        <div class="container-fluid">
            <!-- Multi Column -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="block-header">
                            <h2>Load Status</h2>

                        </div>
                        <form method="post" action="{{ route('load.update', ['id' => $post->id]) }}">
                            @csrf
                            @method('PUT') <!-- Corrected from 'put' to 'PUT' -->
                        
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="load_status">Load Status</label> <!-- Changed 'customer_name' to 'load_status' -->
                                            <select class="form-control" name="load_status">
                                                <option value="{{ $post->load_status }}" selected>{{ $post->load_status }}</option>
                                                <option value="Open">Open</option>
                                                <option value="Covered">Covered</option>
                                                <option value="Dispatched">Dispatched</option>
                                                <option value="Loading">Loading</option>
                                                <option value="On Route">On Route</option>
                                                <option value="Unloading">Unloading</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Deliverd">Deliverd</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-primary">Update Load Status</button> <!-- Changed 'Update Customer' to 'Update Load Status' -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection
