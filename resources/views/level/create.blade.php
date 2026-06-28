@extends('layouts.app')
@section('tittle', 'Create New Level')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('level.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">Level Name *</label>
                    <input type="text" class="form-control" placeholder="Enter level name" name="level_name" required>
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
