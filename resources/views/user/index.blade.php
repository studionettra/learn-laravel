@extends('layouts.app')
@section('title', 'User Management')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-tittle">
                {{ $title ?? '' }}
            </h3>
            <div class="card-body">
                <div class="mb-3" align="right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Create New User</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index += 1 }}</td>
                                <td> {{ $user->name ?? '' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name ?? '-' }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success icon">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger"
                                        data-confirm-delete="true">Delete</a>

                                    {{--  <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                        data-confirm-delete="true">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-delete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                    </form>  --}}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--  <script>
        document.addEventListener('click', function(e) {

            const button = e.target.closest('.btn-delete');

            if (button) {
                e.preventDefault();
                const form = button.closest('.form-delete');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data user yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    </script>  --}}
@endsection
