@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        {{ 'Facility Ticket History' }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>
                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-3">
                            {{-- @can('Create') --}}
                            <a href="{{ route('asset-tickets.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-person-plus"></i> Create New Ticket
                            </a>
                            {{-- @endcan --}}
                        </div>
                        <table id="ticketsTable" class="table table-bordered">
                            <thead class='text-dark'>
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Category ID</th>
                                    <th>Priority</th>
                                    <th>Unit</th>
                                    <th>Division</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $index => $ticket)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $ticket->title }}</td>
                                        <td>{{ $ticket->category_id }}</td>
                                        <td>{{ $ticket->priority }}</td>
                                        <td>{{ $ticket->unit }}</td>
                                        <td>{{ $ticket->division }}</td>
                                        <td>{{ $ticket->status }}</td>
                                        <td>
                                            <a href="{{ route('asset-tickets.show', $ticket) }}"
                                                class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('asset-tickets.edit', $ticket) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('asset-tickets.destroy', $ticket) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this ticket?')"
                                                    class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
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
@endsection
