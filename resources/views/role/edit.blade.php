@extends('layouts.app')
@section('tittle', 'Crate New Role')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('role.update', $edit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="">Name *</label>
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

                <div class="row">
                    @foreach ($parents as $parent)
                        <div class="col-md-6 mb-3">
                            <div class="border rounded p-3 h-100">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="menu_ids[]"
                                        value="{{ $parent->id }}">
                                    <label class="form-check-label fw-bold">
                                        {{ $parent->name }}
                                    </label>
                                </div>

                                @foreach ($parent->children as $child)
                                    <div class="form-check ms-3">
                                        <input type="checkbox" name="menu_ids[]" value="{{ $child->id }}"
                                            class="form-check-input">
                                        <label class="form-check-label">
                                            {{ $child->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
