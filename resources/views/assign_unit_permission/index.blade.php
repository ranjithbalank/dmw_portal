@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                    {{ 'Permission' }}
                    <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('assign-unit-permissions.create') }}" class="btn btn-success shadow-sm">
                            <i class="bi bi-plus-circle"></i> Add Permission
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
