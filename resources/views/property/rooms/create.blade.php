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
                <form action="{{ route('property-rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ request()->query('property_room') }}">
                    <div id="roomFields">
                        <div class="room">
                            <div class="form-floating mb-3">
                                <input type="number" name="capacity[]" class="form-control rounded">
                                <label class="form-label">Capacity</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="price[]" class="form-control rounded">
                                <label class="form-label">Price</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="number[]" class="form-control rounded">
                                <label for="number" class="form-label">Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="singel_beds[]" class="form-control rounded">
                                <label for="single_beds" class="form-label">Single beds</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="double_beds[]" class="form-control rounded">
                                <label for="double_beds" class="form-label">Double beds</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" onclick="addRoom()" class="btn btn-outline-success">Add More</button>
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
@endrole
