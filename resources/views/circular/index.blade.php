@extends('layouts.app')
{{-- DataTables CSS --}}
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        {{ 'Circulars' }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            @hasanyrole(['HR', 'Admin'])
                                <a href="{{ route('circulars.create') }}" class="btn btn-success shadow-sm">
                                    <i class="bi bi-person-plus"></i> Create Circular
                                </a>
                            @endhasanyrole
                        </div>

                        <table id="circularsTable" class="table table-bordered">
                            <thead class="text-dark">
                                <tr>
                                    <th style="width: 10px;">S.No</th>
                                    <th style="width: 30px;">Created Date</th>
                                    <th style="width: 300px;">Circular Name</th>
                                    <th style="width: 70px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($circulars as $index => $circular)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($circular->circular_date)->format('d-m-Y') }}</td>
                                        <td>{{ $circular->circular_no }}</td>
                                        <td class="text-center">

                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#pdfModal{{ $circular->id }}">
                                                    <i class="bi bi-eye"></i> View
                                                </button>

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

    {{-- PDF Viewer Modals --}}
    @foreach ($circulars as $circular)
        <div class="modal fade" id="pdfModal{{ $circular->id }}" tabindex="-1"
            aria-labelledby="pdfModalLabel{{ $circular->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Circular - {{ $circular->circular_no }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="height: 80vh;">
                        <iframe
                            src="{{ url('pdfjs/web/viewer.html') }}?file={{ asset('storage/' . $circular->file_path) }}"
                            width="100%" height="100%" style="border: none;">
                        </iframe>

                    </div>
                    {{-- <div class="modal-footer">
                        <a href="{{ asset('storage/' . $circular->file_path) }}" class="btn btn-success" target="_blank">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#circularsTable').DataTable({
                "order": [], // disable initial ordering
                "pageLength": 10
            });
        });
    </script>
@endsection
