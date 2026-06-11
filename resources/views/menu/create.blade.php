@extends('layouts.app')
@section('tittle', 'Crate New Menu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? '' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('menu.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" value="" placeholder="Enter Name"
                            required>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Parent</label>
                        <select name="parent_id" class="form-select" aria-label="Default select example">
                            <option value="">Select One</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Url *</label>
                        <input type="text" name="url" class="form-control" value="" placeholder="Enter URL">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Icon</label>
                        <input type="text" name="icon" class="form-control" value="" placeholder="Enter Icon">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="" placeholder=" ">
                    </div>
                    <div class="col-6 mb-2">
                        <label for="" class="form-label">Status</label>
                        <select name="is_active" class="form-select" aria-label="Default select example">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="coll-12">
                            <label class="form_label d-block">
                                Assign to Roles
                            </label>
                            @foreach ($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="roles[]" id='role-{{ $role->id }}'
                                        value="{{ $role->id }}">
                                    <label class="form-check-label"
                                        for="role-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Add</button>
                <a href="{{ url()->previous() }}" class="text-secondary">Back</a>
            </form>
        </div>
    </div>

@endsection
