@extends('layouts.app')

@role('client|partner|admin')
    @section('content')
        <div class="container mt-5">
            <div class="row">
                @foreach ($property_rooms as $property_room)
                    <div class="col-12 mb-2 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="col-12 col-md-4">
                                        <div id="property_image{{ $property_room->id }}" class="carousel slide carousel-fade">
                                            <div class="carousel-inner">
                                                @foreach ($property_room->property->property_images as $key => $property_image)
                                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                        <img src="{{ asset('storage/images/property-images/' . $property_image->image) }}"
                                                            class="d-block w-100" alt="{{ $property_image->property->name }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#property_image{{ $property_room->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#property_image{{ $property_room->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 ms-4">
                                        <h5 class="card-title">{{ $property_room->property->name }}</h5>
                                        <p class="card-text">
                                            <div class="col-12">
                                                <span class="p-1">
                                                    <strong class="opacity-100">Capacity:</strong>
                                                    {{ $property_room->capacity }}
                                                </span>
                                                <span class="p-1">
                                                    <strong class="opacity-100">Number:</strong>
                                                    {{ $property_room->number }}
                                                </span>
                                                <span class="p-1">
                                                    <strong class="opacity-100">Price/day:</strong>
                                                    {{ $property_room->price }}
                                                </span>
                                                <span class="p-1">
                                                    <strong class="opacity-100">Singel Beds:</strong>
                                                    {{ $property_room->singel_beds }}
                                                </span>
                                                <span class="p-1">
                                                    <strong class="opacity-100">Double Beds:</strong>
                                                    {{ $property_room->double_beds }}
                                                </span>
                                            </div>
                                        </p>
                                        <form action="{{ route('reservations.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="property_id" value="{{ $property_room->property->id }}">
                                            <input type="hidden" name="property_room_id" value="{{ $property_room->id }}">
                                            <input type="hidden" name="address" value="{{ $property_room->property->locations }}">
                                            <input type="hidden" name="price" value="{{ $property_room->price }}">
                                            <input type="hidden" name="adult" value="{{ request()->query('countAdults') }}">
                                            <input type="hidden" name="child" value="{{ request()->query('countChild') }}">
                                            <input type="hidden" name="country_id" value="{{ request()->query('country_id') }}">
                                            <input type="hidden" name="city_id" value="{{ request()->query('city_id') }}">
                                            <input type="hidden" name="daterange" value="{{ request()->query('daterange') }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Book</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
@endrole
