@extends('layouts.app')

@section('title', 'Create Facility Ticket')
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

@section('content')
    <div class="container">
        <div class="card shadow-sm rounded-4 border-1">
            <div class="card-header d-flex justify-content-between align-items-center  bg-tertiary"
                style="background:#FC5C14; color:white;">
                <span class="fw-semibold">
                    <i class="bi bi-plus-circle text-white me-2"></i> Create Facility Ticket
                </span>
                <a href="{{ route('asset-tickets.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                {{-- ✅ Show validation errors --}}

                <form method="POST" action="{{ route('asset-tickets.store') }}">
                    @csrf

                    {{-- Ticket Info --}}
                    <div class="card mb-3 shadow-sm rounded-3 border-1">
                        <div class="card-header bg-primary text-white fw-semibold rounded-top-3">
                            <i class="bi bi-person-plus text-white me-2"></i> Ticket Info
                        </div>

                        <div class="p-3">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-1">
                                            <i class="bi bi-ticket me-1"></i> Ticket No.
                                        </span>
                                        <input type="text" name="ticket_no" class="form-control border-start-0"
                                            value="{{ $ticketNumber }}" readonly>
                                    </div>

                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-person me-1"></i> Created By
                                        </span>
                                        <input type="text" name="created_by" class="form-control border-start-0"
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>

                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-calendar me-1"></i> Created On
                                        </span>
                                        <input type="date" name="created_on" class="form-control border-start-0"
                                            value="{{ date('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                {{-- Category --}}
                                <div class="col-md-3 mb-2">
                                    <div class="input-group shadow-sm rounded-3">
                                        <select name="category_id" class="form-select select2cat border-start-0" required>
                                            <option value="" selected disabled>Select Category</option>
                                            <option value="1">Electric</option>
                                            <option value="2">Plumbing</option>
                                            <option value="3">Air Conditioner</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Unit --}}
                                <div class="col-md-3 mb-2">
                                    <div class="input-group shadow-sm rounded-3">
                                        <span
                                            class="input-group-text text-danger-emphasis text-secondary fw-semibold border-end-0">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <select name="unit" class="form-select select2unit border-start-0" required>
                                            <option value="" selected disabled>Select Unit</option>
                                            <option value="Perundurai">Perundurai</option>
                                            <option value="Coimbatore - 1">Coimbatore - 1</option>
                                            <option value="Corporate">Corporate</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Division --}}
                                <div class="col-md-3 mb-2">
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-diagram-3"></i>
                                        </span>
                                        <select name="division" class="form-select select2division border-start-0" required>
                                            <option value="" selected disabled>Select Division</option>
                                            <option value="Production">Production</option>
                                            <option value="IT SERVICE">IT SERVICE</option>
                                            <option value="STORES">STORES</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-3 mb-2">
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-clipboard-check"></i>
                                        </span>
                                        <select name="priority" class="form-control">
                                            <option value="Very Urgent">Very Urgent</option>
                                            <option value="Urgent">Urgent</option>
                                            <option value="Very High">Very High</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>

                                    </div>
                                </div>
                            </div>


                            {{-- Issue & Description --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <br>
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            Issue
                                        </span>
                                        <input type="text" name="title" class="form-control border-start-0"
                                            placeholder="E.g., Power fluctuation">
                                    </div>
                                    <br>
                                    {{-- <div class="col-md-6 mb-2"> --}}
                                    <div class="input-group shadow-sm rounded-3">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            Description
                                        </span>
                                        <textarea name="description" class="form-control border-start-0" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2 rounded-pill shadow-sm">
                            <i class="bi bi-check-circle"></i> Create Ticket
                        </button>
                        <a href="{{ route('asset-tickets.index') }}" class="btn btn-secondary rounded-pill shadow-sm">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select an Category',
                allowClear: true,
                width: '100%' // ensures it fits your Bootstrap container
            });


            $('.select2').select2({
                width: '100%',
                placeholder: 'Select User',
                allowClear: true
            });
        });
    </script>
@endsection
