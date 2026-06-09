@extends('layouts.app')
@section('tittle', 'Crate New Key')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('key.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">Name *</label>
                    <input type="text" class="form-control" placeholder="Enter your name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="email" class="form-control" placeholder="example@mail.com" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="">Password</label>
                    <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
