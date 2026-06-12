@extends('layouts.app')
@section('title', 'Crate New Major')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('major.update', $edit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="">Major *</label>
                    <input type="text" class="form-control" placeholder="Enter your name" name="name" required
                        value="{{ $edit->name }}">
                </div>
                <div class="mb-3">
                    <label for="">Status</label>
                    <br>
                    <input type="radio" name="is_active" value="1" {{ $edit->is_active == 1 ? 'checked' : '' }}>
                    Active
                    <br>
                    <input type="radio" name="is_active" value="0" {{ $edit->is_active == 0 ? 'checked' : '' }}> In
                    Active
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
