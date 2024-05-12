@extends('layouts.app')

@section('content')
    @role('client')
        <div class="container p-5">
            <div class="col-12 mx-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="w-100">
                            <div id="property_image{{ $property_room->id }}" class="carousel slide carousel-fade">
                                <div class="carousel-inner">
                                    @foreach ($property_images as $key => $property_image)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }} ratio ratio-4x3">
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
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card rounded-0 border-0">
                            <div class="card-body">
                                <h4 class="card-title">{{ $property_room->property->name }}</h4>
                                <p class="card-text">{{ $property_room->property->country->name }} /
                                    {{ $property_room->property->city->name }} / {{ $property_room->property->locations }}</p>
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Capacity:</strong> {{ $property_room->capacity }}</li>
                                    <li class="list-group-item"><strong>Number:</strong> {{ $property_room->number }}</li>
                                    <li class="list-group-item"><strong>Price/day:</strong> {{ $property_room->price }}</li>
                                    <li class="list-group-item"><strong>Singel Beds:</strong> {{ $property_room->singel_beds }}
                                    </li>
                                    <li class="list-group-item"><strong>Double Beds:</strong> {{ $property_room->double_beds }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
