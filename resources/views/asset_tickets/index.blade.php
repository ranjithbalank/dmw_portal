@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
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
                                    <th style="width: 50px;">S.No</th>
                                    <th style="width: 150px; word-wrap: break-word;">Title</th>
                                    <th style="width: 120px; word-wrap: break-word;">Category ID</th>
                                    <th style="width: 100px; word-wrap: break-word;">Priority</th>
                                    <th style="width: 100px; word-wrap: break-word;">Unit</th>
                                    <th style="width: 100px; word-wrap: break-word;">Division</th>
                                    <th style="width: 100px; word-wrap: break-word;">Status</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $index => $ticket)
                                    <tr>
                                        <td class="text-wrap align-middle">{{ $index + 1 }}</td>
                                        <td class="text-wrap align-middle">{{ ucfirst($ticket->title) }}</td>
                                        <td class="text-wrap align-middle">
                                            @if ($ticket->category_id == '1')
                                                {{ 'Electrical' }}
                                            @elseif($ticket->category_id == '2')
                                                {{ 'Plumbing' }}
                                            @else
                                                {{ 'Unknown' }}
                                            @endif
                                        </td>
                                        <td class="text-wrap align-middle">{{ $ticket->priority }}</td>
                                        <td class="text-wrap align-middle">{{ $ticket->unit }}</td>
                                        <td class="text-wrap align-middle">{{ $ticket->division }}</td>
                                        <td class="text-wrap align-middle text-primary ">{{ $ticket->status }}</td>
                                        <td class="text-center align-middle">
                                            {{-- <a href="{{ route('asset-tickets.show', $ticket) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a> --}}
                                            <a href="{{ route('asset-tickets.edit', $ticket) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('asset-tickets.destroy', $ticket) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Delete this ticket?')"
                                                    class="btn btn-danger btn-sm">
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
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ticketsTable').DataTable({
                "order": [], // disable initial ordering
                "pageLength": 10
            });
        });
    </script>
@endsection
