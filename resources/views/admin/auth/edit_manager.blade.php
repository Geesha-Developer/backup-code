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
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <h2>Leader Details</h2>
        </div>

        <div class="container-fluid p-0">
            <!-- Multi Column -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                        <form method="POST" action="{{ route('update.manager', $manager->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="customer_name"><b>Name</b></label>
                                            <input type="text" class="form-control" id="manager" name="manager"
                                                value="{{ $manager->manager }}" required>
                                        </div>

                                        
                                        <div class="col-md-1">
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" id="managerCheckbox"
                                                    name="manager_check" value="1">
                                                <label class="form-check-label" for="managerCheckbox">Manager</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group form-check">
                                                <input type="checkbox" class="form-check-input" id="tlCheckbox"
                                                    name="tl_check" value="1">
                                                <label class="form-check-label" for="tlCheckbox">TL</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 8px 13px;">Save</button>
                                            <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 13px;">Cancel</button>
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