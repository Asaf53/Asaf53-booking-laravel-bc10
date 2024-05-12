@extends('layouts.app')

@section('content')
    @role('admin')
        <div class="container">
            @if (Session::has('status'))
                <div class="alert alert-info alert-dismissible fade show mt-4" role="alert">
                    {{ Session::get('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive mt-5">
                <div class="w-100 d-flex justify-content-start">
                    <a href="{{ route('property-types.create') }}" class="btn btn-outline-primary">Create Types</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Photo</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $type->name }}</td>
                                <td class="w-25">
                                    <img src="{{ asset('storage/images/property-types/' . $type->photo) }}"
                                        alt="{{ $type->name }}" class="w-50 img-fluid img-thumbnail">
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('property-types.edit', ['property_type' => $type->id]) }}"
                                            class="btn btn-transparent border-0">
                                            <i class="bx bx-edit text-warning h4"></i>
                                        </a>
                                        <form action="{{ route('property-types.destroy', ['property_type' => $type->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-transparent border-0">
                                                <i class="bx bx-trash text-danger h4"
                                                    onclick="return confirm('Are you sure?')"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endrole
@endsection
