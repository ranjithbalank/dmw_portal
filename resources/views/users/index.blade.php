@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        {{ _('Users list') }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-person-plus"></i> Create User
                            </a>
                        </div>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <!-- View Button to trigger modal -->
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Include the modal -->
                                                @include('users.partials.show-modal', ['user' => $user])

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
