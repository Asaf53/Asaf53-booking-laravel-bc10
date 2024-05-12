@extends('layouts.app')

@section('content')
    @role('partner')
        <div class="container">
            <div class="row p-5">
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
                            <h5 class="card-title">Resrvations</h5>
                            <a href="{{ route('reservations.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
    @role('client')
        <div class="container">
            <div class="row p-5">
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Resrvations</h5>
                            <a href="{{ route('reservations.index') }}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
