@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background:#FC5C14; color: white;">
                        {{ 'Holidays' }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">
                        @hasrole(['Employee', 'Manager'])
                            <h5><em>List of the Public Holidays: </em></h5>
                        @endhasrole
                        @hasrole('Admin')
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('holidays.create') }}" class="btn btn-success shadow-sm">
                                    <i class="bi bi-plus-circle"></i> Add Holiday
                                </a>
                            </div>
                        @endhasrole
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    @foreach ($holidays as $index => $holiday)
                                        <tr>
                                            <td class="text-end fst-italic">{{ $index + 1 }}</td>
                                            <td><span class="fst-italic text-danger">{{ $holiday->name }}</span></td>
                                            <td class="p-1 text-start">
                                                <span class="fst-italic">
                                                    &nbsp; {{ \Carbon\Carbon::parse($holiday->date)->format('F d, Y (l)') }}
                                                </span>
                                            </td>


                                            <td class="text-center">
                                                <a href="{{ route('holidays.edit', $holiday->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST"
                                                    style="display: inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this holiday?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($holidays->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">No holidays found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
