@extends('layouts.app')
@section('tittle', 'Crate New Instructor')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('instructor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">Name *</label>

                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter Your Name" name="name" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Major *</label>
                    <select name="major_id" class="form-control @error('major_id') is-invalid @enderror">
                        <option value="">Select One</option>
                        @foreach ($majors as $major)
                            <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                                {{ $major->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('major_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="">Phone *</label>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror"
                        placeholder="Enter Your Phone" name="phone" value="{{ old('phone') }}">

                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Email *</label>
                    <input type="email" name="email" placeholder="Enter Your Email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter Your Password" name="password">

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>


            </form>
        </div>
    </div>

@endsection
