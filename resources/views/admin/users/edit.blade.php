@extends('layouts.app')
@role('superadmin')
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
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-floating mb-3">
                        <input type="text" name="fullname" class="form-control rounded" value="{{ $user->name }}">
                        <label for="fullname" class="form-label">Fullname</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control rounded" value="{{ $user->email }}">
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" name="phone" class="form-control rounded" value="{{ $user->phone }}">
                        <label for="phone" class="form-label">Phone Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" name="role" id="role">
                            <option value="{{ $user->roles->first()->id }}" selected>{{ $user->roles->first()->name }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" class="text-capitalize">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <label for="role" class="form-label">Role</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    @endsection
@endrole
