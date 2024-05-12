@extends('layouts.app')

@section('content')
    @hasanyrole('superadmin|admin')
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
                            <th scope="col">Fullname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
                            @role('superadmin')
                                <th scope="col" class="text-center">Action</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->roles->first()->name }}</td>
                                @role('superadmin')
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                            class="btn btn-transparent border-0">
                                            <i class="bx bx-edit text-warning h4"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
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
