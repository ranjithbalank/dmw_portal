@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <style>
        #calendar {
            min-height: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h3 class="mb-4">DMW Calendar</h3>
        <div id="calendar"></div>
    </div>

    @role('HR')
        {{-- Add Event Modal --}}
        <div class="modal fade" id="addEventModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header" style="background: linear-gradient(90deg,  #fc4a1a, #f7b733);">
                            <h5 class="modal-title text-white">Add Event</h5>
                        </div>
                        <div class="modal-body">
                            <label for="title" class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Event Title" required>
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
                            <label for="start_date" class="form-label">Start Date & Time</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control mb-2" required>
                            <label for="end_date" class="form-label">End Date & Time</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control mb-2" required>
                            <label for="color" class="form-label">Color</label>
                            <input type="color" name="color" class="form-control form-control-color mb-2" value="#3788d8">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-success" type="submit">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Event Modal --}}
        <div class="modal fade" id="editEventModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" id="editEventForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Event</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <input type="text" name="title" id="edit_title" class="form-control mb-2" required>
                            <textarea name="description" id="edit_description" class="form-control mb-2"></textarea>
                            <input type="color" name="color" id="edit_color" class="form-control form-control-color mb-2">
                            <input type="datetime-local" name="start_date" id="edit_start_date" class="form-control mb-2"
                                required>
                            <input type="datetime-local" name="end_date" id="edit_end_date" class="form-control mb-2" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" type="button" id="deleteEventBtn">Delete</button>
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endrole

    {{-- View Modal for All Users --}}
    <div class="modal fade" id="dailyEventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Events on <span id="eventDateTitle"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Color</th>
                            </tr>
                        </thead>
                        <tbody id="dailyEventTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('events.data') }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                dateClick: function(info) {
                    const clickedDate = info.date;
                    const localDate = new Date(clickedDate.getTime() - (clickedDate
                        .getTimezoneOffset() * 60000)).toISOString().slice(0, 16);

                    @role('HR')
                        document.getElementById('start_date').value = localDate;
                        document.getElementById('end_date').value = localDate;
                        new bootstrap.Modal(document.getElementById('addEventModal')).show();
                    @else
                        fetch('{{ route('events.data') }}')
                            .then(res => res.json())
                            .then(events => {
                                const dayStr = info.dateStr;
                                const filtered = events.filter(e => e.start.startsWith(dayStr));
                                const tbody = document.getElementById('dailyEventTable');
                                const title = document.getElementById('eventDateTitle');
                                tbody.innerHTML = '';
                                title.innerText = dayStr;

                                if (filtered.length === 0) {
                                    tbody.innerHTML =
                                        '<tr><td colspan="3" class="text-center">No events</td></tr>';
                                } else {
                                    filtered.forEach(event => {
                                        tbody.insertAdjacentHTML('beforeend', `
                                    <tr>
                                        <td>${event.title}</td>
                                        <td>${event.description || ''}</td>
                                        <td><span style="display:inline-block;width:20px;height:20px;background:${event.color}"></span></td>
                                    </tr>
                                `);
                                    });
                                }

                                new bootstrap.Modal(document.getElementById('dailyEventModal'))
                                    .show();
                            });
                    @endrole
                },

                @role('HR')
                    eventClick: function(info) {
                        const event = info.event;

                        document.getElementById('edit_id').value = event.id;
                        document.getElementById('edit_title').value = event.title;
                        document.getElementById('edit_description').value = event.extendedProps
                            .description || '';
                        document.getElementById('edit_color').value = event.backgroundColor;

                        let start = new Date(event.start);
                        let end = event.end ? new Date(event.end) : start;
                        let startStr = new Date(start.getTime() - (start.getTimezoneOffset() * 60000))
                            .toISOString().slice(0, 16);
                        let endStr = new Date(end.getTime() - (end.getTimezoneOffset() * 60000))
                            .toISOString().slice(0, 16);

                        document.getElementById('edit_start_date').value = startStr;
                        document.getElementById('edit_end_date').value = endStr;

                        document.getElementById('editEventForm').action = `/events/${event.id}`;
                        new bootstrap.Modal(document.getElementById('editEventModal')).show();
                    }
                @endrole
            });

            calendar.render();

            @role('HR')
                document.getElementById('deleteEventBtn')?.addEventListener('click', function() {
                    const eventId = document.getElementById('edit_id').value;
                    if (confirm('Are you sure you want to delete this event?')) {
                        fetch(`/events/${eventId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(response => {
                            if (response.ok) {
                                location.reload();
                            } else {
                                alert('Error deleting event.');
                            }
                        });
                    }
                });
            @endrole
        });
    </script>
@endpush
