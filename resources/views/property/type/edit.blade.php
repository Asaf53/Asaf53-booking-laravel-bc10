@extends('layouts.app')
@section('content')
    @role('admin')
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
                <form action="{{ route('property-types.update', ['property_type' => $type->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control rounded" value="{{ $type->name }}">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <img src="{{ asset('storage/images/properties/' . $type->photo) }}" class="w-100"
                            alt="{{ $type->name }}">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="photo" class="form-control rounded">
                        <label for="photo" class="form-label mb-0">Photo</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </form>
            </div>
        </div>
    @endrole
@endsection
