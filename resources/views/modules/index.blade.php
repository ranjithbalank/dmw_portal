@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-4">
        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">

                <span>Modules</span>
                <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm"><- Back</a>
            </div>

            <div class="card-body table-responsive">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('modules.create') }}" class="btn btn-success shadow-sm">
                        <i class="bi bi-plus-circle"></i> Create Modules
                    </a>
                </div>

                <table class="table table-bordered text-center align-middle" id="modulesTable">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Modules</th>
                            {{-- <th>Status</th> --}}
                            @hasrole('Admin')
                                <th>Action</th>
                            @endhasrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $index => $unit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                {{-- <td class="text-start">{{ ucfirst($unit->code) }}</td> --}}
                                <td class="text-start">{{ ucfirst($unit->name) }}</td>
                                {{-- <td>
                                    @if ($unit->status == 'inactive')
                                        <span class="btn btn-sm btn-danger fw-bold">{{ ucfirst($unit->status) }}</span>
                                    @else
                                        <span class="btn btn-sm btn-success fw-bold">{{ ucfirst($unit->status) }}</span>
                                    @endif
                                </td> --}}
                                @hasrole('Admin')
                                    <td>
                                        <a href="{{ route('modules.edit', $unit->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('modules.destroy', $unit->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this modules?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endhasrole
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#modulesTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                ordering: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Modules..."
                }
            });
        });
    </script>
@endpush
