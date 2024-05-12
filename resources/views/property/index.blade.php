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
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Location</th>
                            <th scope="col">Country</th>
                            <th scope="col">City</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($properties as $property)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $property->name }}</td>
                                <td>{{ $property->property_type->name }}</td>
                                <td>{{ $property->user->name }}</td>
                                <td>{{ $property->locations }}</td>
                                <td>{{ $property->country->name }}</td>
                                <td>{{ $property->city->name }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('property-rooms.show', ['property_room' => $property->id]) }}" class="btn btn-transparent border-0">
                                        <i class="bx bx-show-alt text-success h4"></i>
                                    </a>
                                    <a href="{{ route('property-rooms.create', ['property_room' => $property->id]) }}" class="btn btn-transparent border-0">
                                        <i class="bx bx-plus text-primary h4"></i>
                                    </a>
                                    <a href="{{ route('properties.edit', ['property' => $property->id]) }}"
                                        class="btn btn-transparent border-0">
                                        <i class="bx bx-edit text-warning h4"></i>
                                    </a>
                                    <form action="{{ route('properties.destroy', ['property' => $property->id]) }}"
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
