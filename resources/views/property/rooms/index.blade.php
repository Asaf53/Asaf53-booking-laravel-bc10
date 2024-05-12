@extends('layouts.app')

@section('content')
    @hasanyrole('admin|partner')
        <div class="container">
            @if (Session::has('status'))
                <div class="alert alert-info alert-dismissible fade show mt-4" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table" data-search-align="left" id="table" data-pagination="true" data-toggle="table"
                    data-search="true" data-searchable="true">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Property</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Number</th>
                            <th scope="col">Singel Beds</th>
                            <th scope="col">Double Beds</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($property_rooms as $property_room)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $property_room->property->name }}</td>
                                <td>{{ $property_room->capacity }}</td>
                                <td>{{ $property_room->price }}</td>
                                <td>{{ $property_room->number }}</td>
                                <td>{{ $property_room->singel_beds }}</td>
                                <td>{{ $property_room->double_beds }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('property-rooms.edit', ['property_room' => $property_room->id]) }}"
                                        class="btn btn-transparent border-0">
                                        <i class="bx bx-edit text-warning h4"></i>
                                    </a>
                                    <form
                                        action="{{ route('property-rooms.destroy', ['property_room' => $property_room->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-transparent border-0">
                                            <i class="bx bx-trash text-danger h4" onclick="return confirm('Are you sure?')"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endhasanyrole
@endsection
