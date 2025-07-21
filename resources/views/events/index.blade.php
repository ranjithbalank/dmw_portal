@extends('layouts.app')
@php
    $userRole = auth()->user()->role ?? '';
@endphp

@if($userRole === 'HR')
    <button class="btn btn-success mb-3" id="addEventBtn">+ Add Event</button>
@endif


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <style>
        #calendar {
            min-height: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                <h5 class="mb-0">📅 Business Event Calendar</h5>
                <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark">← Back</a>
            </div>
            <div class="card-body">

                @if ($userRole === 'HR')
                    <div class="mb-3 text-end">
                        <button class="btn btn-success" id="openAddEventModal">
                            <i class="bi bi-plus-circle"></i> Add Event
                        </button>
                    </div>
                @endif
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @if ($userRole === 'HR')
        <!-- Add/Edit Event Modal -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="eventForm">
                    @csrf
                    <input type="hidden" name="event_id" id="event_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" name="title" id="event_title" class="form-control" required>
                                <label for="event_title">Title</label>
                            </div>
                            <div class="mb-3">
                                <label for="event_description" class="form-label">Description</label>
                                <textarea name="description" id="event_description" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="event_color" class="form-label">Event Color</label>
                                <input type="color" name="color" id="event_color"
                                    class="form-control form-control-color" value="#3788D8" title="Choose event color"
                                    style="width: 100px;">
                            </div>
                            <div class="form-floating mb-3">
                                <input type="datetime-local" name="start" id="event_start" class="form-control" required>
                                <label for="event_start">Start Date & Time</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="datetime-local" name="end" id="event_end" class="form-control" required>
                                <label for="event_end">End Date & Time</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Event</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Events on Date Modal -->
    <div class="modal fade" id="dateEventsModal" tabindex="-1" aria-labelledby="dateEventsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                    <h5 class="modal-title text-white">Events on <span id="selectedDate"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventsList">
                    <!-- Events will be listed here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const userRole = @json($userRole);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            function formatDateAs_DD_MON_YYYY(date) {
                const months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                const d = new Date(date);
                const day = String(d.getDate()).padStart(2, '0');
                const month = months[d.getMonth()];
                const year = d.getFullYear();
                return `${day}-${month}-${year}`;
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                events: '{{ route('events.data') }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                dateClick: function(info) {
                    const clickedDate = info.dateStr;
                    document.getElementById('selectedDate').textContent = formatDateAs_DD_MON_YYYY(clickedDate);

                    const allEvents = calendar.getEvents();
                    const eventsOnDate = allEvents.filter(event => {
                        const eventDate = event.start.toISOString().split('T')[0];
                        return eventDate === clickedDate;
                    });

                    const eventListHTML = eventsOnDate.length > 0 ?
                        `<ul class="list-group">${eventsOnDate.map(e => `
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>${e.title}</strong><br>
                                    <small>${e.extendedProps.description || 'No description'}</small>
                                </div>
                                <span class="badge bg-primary">${new Date(e.start).toLocaleTimeString([], {
                                    hour: '2-digit', minute: '2-digit'
                                })}</span>
                            </li>
                        `).join('')}</ul>` :
                        '<p class="text-muted">No events for this date.</p>';

                    document.getElementById('eventsList').innerHTML = eventListHTML;
                    new bootstrap.Modal(document.getElementById('dateEventsModal')).show();
                },
                select: function(info) {
                    if (userRole === 'hr') {
                        clearForm();
                        document.getElementById('event_start').value = formatDateTimeLocal(info.start);
                        document.getElementById('event_end').value = formatDateTimeLocal(info.end ?? info.start);
                        new bootstrap.Modal(document.getElementById('eventModal')).show();
                    }
                },
                eventClick: function(info) {
                    const event = info.event;
                    clearForm();
                    document.getElementById('event_id').value = event.id;
                    document.getElementById('event_title').value = event.title;
                    document.getElementById('event_description').value = event.extendedProps.description ?? '';
                    document.getElementById('event_color').value = event.backgroundColor ?? '#3788D8';
                    document.getElementById('event_start').value = formatDateTimeLocal(event.start);
                    document.getElementById('event_end').value = formatDateTimeLocal(event.end ?? event.start);
                    new bootstrap.Modal(document.getElementById('eventModal')).show();
                }
            });

            calendar.render();

            if (userRole === 'HR') {
                document.getElementById('openAddEventModal').addEventListener('click', function () {
                    clearForm();

                    // Set default start/end as current date & time
                    const now = new Date();
                    document.getElementById('event_start').value = formatDateTimeLocal(now);
                    now.setHours(now.getHours() + 1);
                    document.getElementById('event_end').value = formatDateTimeLocal(now);

                    new bootstrap.Modal(document.getElementById('eventModal')).show();
                });

                document.getElementById('eventForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = e.target;
                    const formData = new FormData(form);
                    const eventId = formData.get('event_id');

                    const url = eventId ? `/events/${eventId}` : `{{ route('events.store') }}`;
                    const method = eventId ? 'PUT' : 'POST';

                    fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            calendar.refetchEvents();
                            bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                        } else {
                            alert('Something went wrong!');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Error saving event.');
                    });
                });
            }

            function clearForm() {
                document.getElementById('eventForm').reset();
                document.getElementById('event_id').value = '';
                document.getElementById('event_color').value = '#3788D8';
            }

            function formatDateTimeLocal(date) {
                const d = new Date(date);
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                const hours = String(d.getHours()).padStart(2, '0');
                const minutes = String(d.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        });
    </script>
@endpush
