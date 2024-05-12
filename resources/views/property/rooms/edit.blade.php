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
                <form action="{{ route('property-rooms.update', ['property_room' => $property_rooms->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="property_id" value="{{ $property_rooms->property_id }}">
                    <div id="roomFields">
                        <div class="room">
                            <div class="form-floating mb-3">
                                <input type="number" name="capacity" value="{{ $property_rooms->capacity }}"
                                    class="form-control rounded">
                                <label class="form-label">Capacity</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="price" value="{{ $property_rooms->price }}"
                                    class="form-control rounded">
                                <label class="form-label">Price</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="number" value="{{ $property_rooms->number }}"
                                    class="form-control rounded">
                                <label for="number" class="form-label">Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="singel_beds" value="{{ $property_rooms->singel_beds }}"
                                    class="form-control rounded">
                                <label for="single_beds" class="form-label">Single beds</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="double_beds" value="{{ $property_rooms->double_beds }}"
                                    class="form-control rounded">
                                <label for="double_beds" class="form-label">Double beds</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
@endrole
