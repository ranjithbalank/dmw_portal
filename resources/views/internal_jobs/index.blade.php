@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        {{ 'Internal Job Posting' }}
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
                                <a href="{{ route('internal-jobs.create') }}" class="btn btn-success shadow-sm">
                                    <i class="bi bi-person-plus"></i> Create New Job
                                </a>
                            @else
                                <span class="text-muted mt-2"></span>
                            @endhasanyrole
                        </div>


                        <table id="ticketsTable" class="table table-bordered">
                            <thead class="text-dark">
                                <tr>
                                    <th style="width: 15px;">S.No</th>
                                    <th style="width: 100px; word-wrap: break-word;">Role Name</th>
                                    <th style="width: 100px; word-wrap: break-word;">Qualification</th>
                                    <th style="width: 100px; word-wrap: break-word;">Experience</th>
                                    <th style="width: 100px; word-wrap: break-word;">Unit</th>
                                    <th style="width: 40px; word-wrap: break-word;">Slots</th>
                                    <th style="width: 100px; word-wrap: break-word;">Last Date</th>
                                    <th style="width: 100px; word-wrap: break-word;">Status</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($jobs as $index => $job)
                                    @if ($job->status === 'active' || Auth::user()->hasAnyRole(['HR','Admin']))
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucfirst($job->job_title) }}</td>
                                            <td>{{ $job->qualifications }}</td>
                                            <td class="text-center">{{ $job->work_experience }}</td>
                                            <td>{{ $job->unit }}</td>
                                            <td>{{ $job->slot_available }}</td>
                                            <td>{{ \Carbon\Carbon::parse($job->end_date)->format('d-m-Y') }}</td>
                                            <td class="text-center py-2">
                                                <span
                                                    class="btn btn-sm
                                                    {{ $job->status == 'active' ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                {{-- View button opens offcanvas --}}
                                                <button class="btn btn-info btn-sm" type="button"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasBottom{{ $job->id }}"
                                                    aria-controls="offcanvasBottom{{ $job->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                @hasanyrole(['Admin|HR'])
                                                    {{-- Edit and Delete buttons --}}
                                                    <a href="{{ route('internal-jobs.edit', $job->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    {{-- <form action="{{ route('internal-jobs.destroy', $job->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Delete this job?')"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                @endhasanyrole
                                            </td>
                                        </tr>

                                        {{-- Include the offcanvas partial --}}
                                        @include('internal_jobs.show', ['job' => $job])
                                    @endif
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
