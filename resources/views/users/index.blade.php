@extends('layouts.app')

@section('styles')
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/yadcf@0.9.4/jquery.dataTables.yadcf.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                        {{ _('Users list') }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                            ← Back
                        </a>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-end mb-3">
                            {{-- @can('Create') --}}
                            <a href="{{ route('users.create') }}" class="btn btn-success shadow-sm">
                                <i class="bi bi-person-plus"></i> Create User
                            </a>
                            {{-- @endcan --}}
                        </div>

                        <div class="table-responsive">
                            <table id="usersTable" class="table table-striped table-bordered nowrap align-middle"
                                style="width:100%">
                                <thead class="">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @foreach ($user->getRoleNames() as $roles)
                                                    <span class="badge bg-success">{{ $roles }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                @include('users.partials.show-modal', ['user' => $user])
                                                @hasanyrole(['Admin'])
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Are you sure, Do you Really Want to Delete the Employee?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endhasanyrole
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

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.3.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/yadcf@0.9.4/jquery.dataTables.yadcf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    {{-- <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ], // sort by S.No
                columnDefs: [{
                        orderable: false,
                        targets: -1
                    } // disable sort for Action column
                ]
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            var table = $('.table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });

            // yadcf.init(table, [
            //     // adjust column_number based on your actual table
            //     @if (request()->get('view') === 'team')
            //         {
            //             column_number: 1,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Employee"
            //         }, {
            //             column_number: 2,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Leave Type"
            //         }, {
            //             column_number: 3,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Duration"
            //         }, {
            //             column_number: 4,
            //             filter_type: "text",
            //             filter_default_label: "Filter From / Worked"
            //         }, {
            //             column_number: 5,
            //             filter_type: "text",
            //             filter_default_label: "Filter To / Comp off"
            //         }, {
            //             column_number: 6,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Days"
            //         }, {
            //             column_number: 7,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Reason"
            //         }, {
            //             column_number: 8,
            //             filter_type: "multi_select",
            //             select_type: 'select2',
            //             filter_default_label: "Filter by Status"
            //         }
            //     @else
            //         {
            //             column_number: 1,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Leave Type"
            //         }, {
            //             column_number: 2,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Duration"
            //         }, {
            //             column_number: 3,
            //             filter_type: "text",
            //             filter_default_label: "Filter From / Worked"
            //         }, {
            //             column_number: 4,
            //             filter_type: "text",
            //             filter_default_label: "Filter To / Comp off"
            //         }, {
            //             column_number: 5,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Days"
            //         }, {
            //             column_number: 6,
            //             filter_type: "text",
            //             filter_default_label: "Filter by Reason"
            //         }, {
            //             column_number: 7,
            //             filter_type: "multi_select",
            //             select_type: 'select2',
            //             filter_default_label: "Filter by Status"
            //         }
            //     @endif
            // ]);
        });
    </script>
@endsection
