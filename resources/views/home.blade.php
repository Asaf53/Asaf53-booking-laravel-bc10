@extends('layouts.app')


@role('superadmin')
    @section('content')
        <div class="container">
            <div class="row p-5">
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endrole
@role('admin')
    @section('content')
        <div class="container">
            <div class="row p-5">
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Properties</h5>
                            <a href="{{ route('properties.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Properties Type</h5>
                            <a href="{{ route('property-types.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Locations</h5>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endrole
@section('content')
    <section class="bg-blue p-5">
        <div class="container py-5">
            <h1 class="text-white fw-900 fs-24">Find your next stay</h1>
            <p class="text-white fs-4">Search low prices on hotels, homes and much more...</p>
        </div>
    </section>

    <section class="mt-4 w-100">
        <div class="container">
            <form action="{{ route('reservations.create') }}" class="d-md-flex justify-content-center bg-warning p-1 rounded" method="GET">
                <input type="hidden" name="countAdults" id="countAdults">
                <input type="hidden" name="countChild" id="countChild">
                <div class="form-floating mb-md-0 mb-2 me-md-2 w-100">
                    <select class="form-select" name="country_id" id="country">
                        <option value="" selected>Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <label for="country" class="form-label">Where are you going?</label>
                </div>
                <div class="form-floating mb-md-0 mb-2 me-md-2 w-100">
                    <select class="form-select" name="city_id" id="city" aria-label="Default select example">
                        <option value="" selected>City</option>
                    </select>
                    <label for="city" class="form-label">City</label>
                </div>
                <div class="form-floating mb-md-0 mb-2 me-md-2 w-100">
                    <input type="text" name="daterange" class="form-control rounded border-0" id="checkin_chekout">
                    <label for="checkin_chekout" class="form-label">Checkin / Checkout</label>
                </div>
                <div class="form-floating mb-md-0 mb-2 me-md-2 w-100">
                    <button type="button" class="btn btn-light border-0 w-100 h-100" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <span class="countAdults" name="countAdults">0</span><span class="me-2 ms-1">adults</span>
                        <span class="countChild" name="countChild">0</span><span class="me-2 ms-1">children</span>
                    </button>
                    <div class="collapse position-absolute z-index-5 w-100" id="collapseExample">
                        <div class="card card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-block">
                                    <h6 class="mb-0 text-start">Adults</h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-35">
                                    <button type="button" class="btn btn-sm btn-dark rounded-circle bg-dark"
                                        onclick="decNumber('countAdults')">
                                        <i class="bx bx-minus"></i>
                                    </button>
                                    <span class="countAdults">0</span>
                                    <button type="button" class="btn btn-sm btn-dark rounded-circle bg-dark"
                                        onclick="incNumber('countAdults')">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-block">
                                    <h6 class="mb-0 text-start">Children</h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-35">
                                    <button type="button" class="btn btn-sm btn-dark rounded-circle bg-dark"
                                        onclick="decNumber('countChild')">
                                        <i class="bx bx-minus"></i>
                                    </button>
                                    <span class="countChild">0</span>
                                    <button type="button" class="btn btn-sm btn-dark rounded-circle bg-dark"
                                        onclick="incNumber('countChild')">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-hover d-flex align-items-center">
                    <span class="mb-0 me-2 h5">Search</span>
                    <i class="mb-0 h5 bx bx-search"></i>
                </button>
            </form>
        </div>
    </section>

    <section class="container mt-4">
        <h1 class="h1">Discover your destination</h1>
        <p class="h6 fw-normal">Explore our range of property types for every traveler's preference.</p>
        <div class="row mt-5">
            @foreach ($types as $type)
                <div class="col-12 col-md-4 col-lg-3 mt-md-0 mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-block">
                            <h3 class="h3">{{ $type->name }}</h3>
                            <p><i class="bx bx-home me-2"></i>{{ $type->property()->count() }} available</p>
                        </div>
                    </div>
                    <img src="{{ asset('storage/images/property-types/' . $type->photo) }}" class="rounded img-fluid" alt="{{ $type->name }}">
                </div>
            @endforeach
        </div>
    </section>
@endsection
