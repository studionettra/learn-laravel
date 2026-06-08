@extends('layouts.app')
@section('title', 'Edit Locker')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('locker.update', $locker->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="">Locker Code *</label>
                    <input type="text" class="form-control @error('locker_name') is-invalid @enderror"
                        value="{{ $locker->locker_name }}" placeholder="Enter your Locker" name="locker_name" required>

                    @error('locker_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Batch *</label>
                    <select name="batch" class="form-select" required>
                        <option value="">--Choose Batch--</option>
                        <option value="1" {{ $locker->batch == '1' ? 'selected' : '' }}>Batch 1</option>
                        <option value="2" {{ $locker->batch == '2' ? 'selected' : '' }}>Batch 2</option>
                        <option value="3" {{ $locker->batch == '3' ? 'selected' : '' }}>Batch 3</option>
                        <option value="4" {{ $locker->batch == '4' ? 'selected' : '' }}>Batch 4</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Major *</label>
                    <select name="major_name" class="form-select" required>
                        <option value="">--Choose Major--</option>
                        <option value="Web Programming" {{ $locker->major_name == 'Web Programming' ? 'selected' : '' }}>Web
                            Programming</option>
                        <option value="Content Creator" {{ $locker->major_name == 'Content Creator' ? 'selected' : '' }}>
                            Content Creator</option>
                        <option value="Multimedia" {{ $locker->major_name == 'Multimedia' ? 'selected' : '' }}>
                            Multimedia
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="">--Choose status--</option>
                        <option value="Available" {{ $locker->status == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Unavailable" {{ $locker->status == 'Unavailable' ? 'selected' : '' }}>Unavailable
                        </option>
                        <option value="Damaged" {{ $locker->status == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                        <option value="Missing" {{ $locker->status == 'Missing' ? 'selected' : '' }}>Missing</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
