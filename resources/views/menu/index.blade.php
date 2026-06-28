@extends('layouts.app')
@section('title', 'Menu Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('menu.create') }}" class="btn btn-primary">Create New Menu</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Url</th>
                            <th>Akses</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $index => $menu)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->parent_id ? $menu->parents->name : '-' }}</td>
                                <td>{{ $menu->url }}</td>
                                <td>
                                    @foreach ($menu->roles as $role)
                                        <span class="badge bg-success text-white">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if ($menu->is_active == 1)
                                        <span class="badge text-white bg-primary">Active</span>
                                    @else
                                        <span class="badge text-white bg-danger">In Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('menu.destroy', $menu->id) }}" class="btn btn-danger icon"
                                        data-confirm-delete="true">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
