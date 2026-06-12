@extends('layouts.app')
@section('title', 'Crate New User Role')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('user-role.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">User *</label>
                    <select name="user_id" id="" class="form-control" required>
                        <option value="">Select One</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Role *</label>
                    <select name="role_id" id="" class="form-control" required>
                        <option value="">Select One</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
