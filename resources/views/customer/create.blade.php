@extends('layouts.app')
@section('title', 'Create New Customer')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="">Customer Name *</label>
                    <input type="text" class="form-control" placeholder="Enter customer name" name="customer_name" required value="{{ old('customer_name') }}">
                </div>
                <div class="mb-3">
                    <label for="">Phone Number *</label>
                    <input type="text" class="form-control" placeholder="Enter phone number" name="phone" required value="{{ old('phone') }}">
                </div>
                <div class="mb-3">
                    <label for="">Address *</label>
                    <textarea class="form-control" placeholder="Enter address" name="address" rows="3" required>{{ old('address') }}</textarea>
                </div>
                
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
