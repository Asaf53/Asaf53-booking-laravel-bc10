@extends('layouts.app')
@hasanyrole('admin|partner')
    @section('content')
        <div class="container">
            <div class="col-12 col-md-4 mx-auto mt-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('properties.update', ['property' => $property->id]) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control rounded" value="{{ $property->name }}">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    @role('admin')
                        <div class="form-floating mb-3">
                            <select class="form-select" name="user_id" id="user_id">
                                <option value="{{ $property->user->id }}" selected>{{ $property->user->name }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <label for="user_id" class="form-label">User</label>
                        </div>
                    @endrole
                    <div class="form-floating mb-3">
                        <select class="form-select" name="types" id="types">
                            <option value="{{ $property->property_type->id }}" selected>{{ $property->property_type->name }}
                            </option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <label for="types" class="form-label">Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control rounded" value="{{ $property->locations }}">
                        <label for="address" class="form-label">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="country_id" id="country_id">
                            <option value="{{ $property->country->id }}" selected>{{ $property->country->name }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <label for="country_id" class="form-label">Country</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="city_id" id="city_id">
                            <option value="{{ $property->city->id }}" selected>{{ $property->city->name }}</option>
                        </select>
                        <label for="city_id" class="form-label">City</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="images[]" multiple class="form-control rounded">
                        <label for="images" class="form-label">Images</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    @endsection
@endhasanyrole
