@extends('layouts.app')
@role('partner')
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
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control rounded" value="">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="types" id="types">
                            <option value="" selected>Choose Type</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        <label for="types" class="form-label">Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="address" class="form-control rounded">
                        <label for="address" class="form-label">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="country_id" id="country_id">
                            <option value="" selected>Choose Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <label for="country_id" class="form-label">Country</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="city_id" id="city_id">
                            <option value="" selected>Choose City</option>
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
@endrole
