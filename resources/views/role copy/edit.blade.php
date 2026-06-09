@extends('layouts.app')
@section('tittle', 'Edit Student')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('student.update', $edit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="">Name *</label>
                    <input type="text" class="form-control" placeholder="Enter your name" name="name" required
                        value="{{ $edit->name }}">
                </div>
                <div class="mb-3">
                    <label for="">Phone *</label>
                    <input type="text" class="form-control" placeholder="Enter your phone" name="phone" required
                        value="{{ $edit->phone }}">
                </div>
                <div class="mb-3">
                    <label for="">Major *</label>
                    <select name="major_id" id="" class="form-control">
                        <option value="">Select One</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}"{{ $major->id == $edit->major_id ? 'selected' : '' }}>
                                {{ $major->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
