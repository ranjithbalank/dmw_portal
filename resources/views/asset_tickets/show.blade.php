@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ticket Details</h2>

    <div class="mb-2"><strong>Title:</strong> {{ $assetTicket->title }}</div>
    <div class="mb-2"><strong>Description:</strong> {{ $assetTicket->description }}</div>
    <div class="mb-2"><strong>Category ID:</strong> {{ $assetTicket->category_id }}</div>
    <div class="mb-2"><strong>Priority:</strong> {{ $assetTicket->priority }}</div>
    <div class="mb-2"><strong>Unit:</strong> {{ $assetTicket->unit }}</div>
    <div class="mb-2"><strong>Division:</strong> {{ $assetTicket->division }}</div>
    <div class="mb-2"><strong>Status:</strong> {{ $assetTicket->status }}</div>

    <a href="{{ route('asset-tickets.edit', $assetTicket) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('asset-tickets.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
