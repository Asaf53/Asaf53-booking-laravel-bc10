@extends('layouts.app')
@role('admin')
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
                <form action="{{ route('property-types.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control rounded">
                        <label for="name" class="form-label">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" name="photo" class="form-control rounded">
                        <label for="photo" class="form-label mb-0">Photo</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </form>
            </div>
        </div>
    @endsection
@endrole
