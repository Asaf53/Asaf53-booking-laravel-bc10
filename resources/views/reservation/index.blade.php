@extends('layouts.app')

@section('content')
    @hasanyrole('client|partner')
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
                            <th scope="col">Client Name</th>
                            <th scope="col">Property Name</th>
                            <th scope="col">Property Room No</th>
                            <th scope="col">Country</th>
                            <th scope="col">City</th>
                            <th scope="col">Address</th>
                            <th scope="col">Price</th>
                            <th scope="col">Check In</th>
                            <th scope="col">Check Out</th>
                            <th scope="col">People</th>
                            <th scope="col">Status</th>
                            @role('partner')
                            <th scope="col" class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($reservation as $reserved)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $reserved->user->name }}</td>
                                <td>{{ $reserved->property->name }}</td>
                                <td>{{ $reserved->property_room->number }}</td>
                                <td>{{ $reserved->country->name }}</td>
                                <td>{{ $reserved->city->name }}</td>
                                <td>{{ $reserved->address }}</td>
                                <td>{{ $reserved->price }}</td>
                                <td>{{ $reserved['check-in'] }}</td>
                                <td>{{ $reserved['check-out'] }}</td>
                                <td>{{ $reserved->people }}</td>
                                <td><span class="badge {{ $reserved->status === 'confirmed' ? 'text-bg-success' : ($reserved->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ $reserved->status }}</span></td>
                                @role('partner')
                                    <td class="d-flex justify-content-center">
                                        <form method="POST" action="{{ route('reservations.update', $reserved->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-transparent border-0" name="confirm">
                                                <i class="bx bx-check text-success h4"></i>
                                            </button>
                                            <button type="submit" class="btn btn-transparent border-0" name="reject">
                                                <i class="bx bx-x text-danger h4"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('reservations.destroy', ['reservation' => $reserved->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-transparent border-0">
                                                <i class="bx bx-trash text-danger h4" onclick="return confirm('Are you sure?')"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endhasanyrole
@endsection
