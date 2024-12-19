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



<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('create.new.login') }}" id="registrationForm" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                    <div class="invalid-feedback" id="passwordError" style="display: none;">Password not match</div>
                </div>

                <div class="form-group">
                    <label for="password">Manager:</label>
                    <select name="manager" id="manager" class="form-control" required>
                        <option value="">Select Manager</option>
                        @php $managers = App\Models\Manger::get(); @endphp
                        @foreach($managers as $manager)
                            <option value="{{ $manager->manager }}">{{ $manager->manager }}</option>
                        @endforeach
                    </select>    
                </div>

                <div class="form-group">
                    <label for="team_lead">Team Lead:</label>
                    <select name="team_lead" id="team_lead" class="form-control" required>
                        <option value="">Select Team Lead</option>
                        @php $tls = App\Models\TeamLeader::get(); @endphp
                        @foreach($tls as $tl)
                            <option value="{{ $tl->tl }}">{{ $tl->tl }}</option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
            alert('hi');
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


@endsection