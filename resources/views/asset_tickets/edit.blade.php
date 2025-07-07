@extends('layouts.app')

@section('title', 'Edit Facility Ticket')

@section('content')
    <div class="container">
        <div class="card shadow-sm rounded-4 border-1">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background:#FC5C14; color:white;">
                <span class="fw-semibold">
                    <i class="bi bi-pencil-square text-white me-2"></i> Edit Facility Ticket
                </span>
                <a href="{{ route('asset-tickets.index') }}" class="btn btn-light btn-sm text-dark shadow-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('asset-tickets.update', $assetTicket->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Ticket Info --}}
                    <div class="card mb-3 shadow-sm rounded-3 border-1">
                        <div class="card-header bg-primary text-white fw-semibold rounded-top-3">
                            <i class="bi bi-ticket me-2"></i> Ticket Info
                        </div>
                        <div class="p-3">
                            <div class="row mb-3">
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-1">
                                            <i class="bi bi-ticket me-1"></i> Ticket No.
                                        </span>
                                        <input type="text" name="ticket_no" class="form-control border-start-0"
                                            value="{{ old('ticket_no', $assetTicket->id) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-person me-1"></i> Created By
                                        </span>
                                        <input type="text" name="created_by" class="form-control border-start-0"
                                            value="{{ old('created_by', $assetTicket->created_by) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text text-danger-emphasis fw-semibold border-end-0">
                                            <i class="bi bi-calendar me-1"></i> Created On
                                        </span>
                                        <input type="date" name="created_on" class="form-control border-start-0"
                                            value="{{ old('created_on', $assetTicket->created_on) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                {{-- Category --}}
                                <div class="col-md-3 mb-2">
                                    <select name="category_id" class="form-select select2" required>
                                        <option value="" disabled>Select Category</option>
                                        <option value="1"
                                            {{ old('category_id', $assetTicket->category_id) == '1' ? 'selected' : '' }}>
                                            Electric</option>
                                        <option value="2"
                                            {{ old('category_id', $assetTicket->category_id) == '2' ? 'selected' : '' }}>
                                            Plumbing</option>
                                        <option value="3"
                                            {{ old('category_id', $assetTicket->category_id) == '3' ? 'selected' : '' }}>Air
                                            Conditioner</option>
                                    </select>
                                </div>
                                {{-- Unit --}}
                                <div class="col-md-3 mb-2">
                                    <select name="unit" class="form-select select2" required>
                                        <option value="" disabled>Select Unit</option>
                                        <option value="Perundurai"
                                            {{ old('unit', $assetTicket->unit) == 'Perundurai' ? 'selected' : '' }}>
                                            Perundurai</option>
                                        <option value="Coimbatore - 1"
                                            {{ old('unit', $assetTicket->unit) == 'Coimbatore - 1' ? 'selected' : '' }}>
                                            Coimbatore - 1</option>
                                        <option value="Corporate"
                                            {{ old('unit', $assetTicket->unit) == 'Corporate' ? 'selected' : '' }}>
                                            Corporate</option>
                                    </select>
                                </div>
                                {{-- Division --}}
                                <div class="col-md-3 mb-2">
                                    <select name="division" class="form-select select2" required>
                                        <option value="" disabled>Select Division</option>
                                        <option value="Production"
                                            {{ old('division', $assetTicket->division) == 'Production' ? 'selected' : '' }}>
                                            Production</option>
                                        <option value="IT SERVICE"
                                            {{ old('division', $assetTicket->division) == 'IT SERVICE' ? 'selected' : '' }}>
                                            IT SERVICE</option>
                                        <option value="STORES"
                                            {{ old('division', $assetTicket->division) == 'STORES' ? 'selected' : '' }}>
                                            STORES</option>
                                    </select>
                                </div>
                                {{-- Priority --}}
                                <div class="col-md-3 mb-2">
                                    <select name="priority" class="form-select select2" required>
                                        <option value="" disabled>Select Priority</option>
                                        @foreach (['1' => 'Urgent', '2' => 'Very High', '3' => 'High', '4' => 'Medium', '5' => 'Low'] as $val => $label)
                                            <option value="{{ $val }}"
                                                {{ old('priority', $assetTicket->priority) == $val ? 'selected' : '' }}>
                                                {{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Issue & Description --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-2">
                                    <div class="input-group shadow-sm rounded-3 mb-2">
                                        <span
                                            class="input-group-text text-danger-emphasis fw-semibold border-end-0">Issue</span>
                                        <input type="text" name="title" class="form-control border-start-0"
                                            value="{{ old('title', $assetTicket->title) }}"
                                            placeholder="E.g., Power fluctuation">
                                    </div>
                                    <div class="input-group shadow-sm rounded-3">
                                        <span
                                            class="input-group-text text-danger-emphasis fw-semibold border-end-0">Description</span>
                                        <textarea name="description" class="form-control border-start-0" rows="3">{{ old('description', $assetTicket->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Assignment Info if status is Yet to Assigned OR Assigned and data exists --}}
                    @hasanyrole('Facility')
                        @if ($assetTicket->status == 'Yet to Assigned' || ($assetTicket->status == 'Assigned' && $assetTicket->assigned_to))
                            <div class="card mb-3 shadow-sm rounded-3 border-1">
                                <div class="card-header bg-success text-white fw-semibold rounded-top-3">
                                    <i class="bi bi-person-plus text-white me-2"></i> Assignment Info
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6 mb-2">
                                            <div class="input-group shadow-sm">
                                                <span
                                                    class="input-group-text bg-white text-success fw-semibold border-end-0">Assigned
                                                    By</span>
                                                <input type="text" name="assigned_by" class="form-control border-start-0"
                                                    value="{{ old('assigned_by', $assetTicket->assigned_by) ?? Auth::user()->name }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="input-group shadow-sm">
                                                <span
                                                    class="input-group-text bg-white text-success fw-semibold border-end-0">Assigned
                                                    On</span>
                                                <input type="date" name="assigned_on" class="form-control border-start-0"
                                                    value="{{ old('assigned_on', $assetTicket->assigned_on ?? date('Y-m-d')) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label text-success fw-semibold">Assigned To</label>
                                            <select name="assigned_to" class="form-select select2 shadow-sm" required>
                                                <option value="" disabled>Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ old('assigned_to', $assetTicket->assigned_to) == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endhasanyrole

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success me-2 rounded-pill shadow-sm">
                            <i class="bi bi-check-circle"></i> Update Ticket
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
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });
        });
    </script>
@endsection
