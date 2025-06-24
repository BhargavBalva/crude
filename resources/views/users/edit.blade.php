@extends('layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" id="userForm">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required>{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" id="image">
            @if($user->image)
                <img id="preview" src="{{ asset('storage/' . $user->image) }}" alt="Image Preview" style="max-height:100px; margin-top:10px;">
            @else
                <img id="preview" src="#" alt="Image Preview" style="max-height:100px; display:none; margin-top:10px;">
            @endif
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Country</label>
                <select name="country_id" id="country" class="form-control" required>
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->id == old('country_id', $user->country_id) ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>State</label>
                <select name="state_id" id="state" class="form-control" required>
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}" {{ $state->id == old('state_id', $user->state_id) ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>City</label>
                <select name="city_id" id="city" class="form-control" required>
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id == old('city_id', $user->city_id) ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Image preview on file select
    $('#image').change(function() {
        const reader = new FileReader();
        reader.onload = e => $('#preview').attr('src', e.target.result).show();
        reader.readAsDataURL(this.files[0]);
    });

    // Fetch states on country change
    $('#country').change(function() {
        const countryId = $(this).val();
        $('#state').html('<option value="">Loading...</option>');
        $('#city').html('<option value="">Select City</option>');

        $.get(`/get-states/${countryId}`, function(states) {
            let options = '<option value="">Select State</option>';
            states.forEach(state => {
                options += `<option value="${state.id}">${state.name}</option>`;
            });
            $('#state').html(options);
        });
    });

    // Fetch cities on state change
    $('#state').change(function() {
        const stateId = $(this).val();
        $('#city').html('<option value="">Loading...</option>');

        $.get(`/get-cities/${stateId}`, function(cities) {
            let options = '<option value="">Select City</option>';
            cities.forEach(city => {
                options += `<option value="${city.id}">${city.name}</option>`;
            });
            $('#city').html(options);
        });
    });
</script>
@endsection
