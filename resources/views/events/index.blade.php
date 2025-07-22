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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                        {{ 'Calendar' }}
                        <a href="{{ route('home') }}" class="btn btn-light btn-sm text-dark shadow-sm">← Back</a>
                    </div>

                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Event Modal --}}
    @role('HR')
        <div class="modal fade" id="addEventModal" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header text-white"  style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                            <h5 class="modal-title">Add Event</h5>
                        </div>
                        <div class="modal-body">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control mb-2" required>

                            <label>Description</label>
                            <textarea name="description" class="form-control mb-2"></textarea>

                            <label>Start Date & Time</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control mb-2" required>

                            <label>End Date & Time</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control mb-2" required>

                            <label>Color</label>
                            <input type="color" name="color" value="#3788d8" class="form-control form-control-color mb-2">
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
                        <div class="modal-header text-white"  style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                            <h5 class="modal-title">Edit Event</h5>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit_id">
                            <label>Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control mb-2" required>
                            <label>Description</label>
                            <textarea name="description" id="edit_description" class="form-control mb-2"></textarea>

                            <label>Start Date & Time</label>
                            <input type="datetime-local" name="start_date" id="edit_start_date" class="form-control mb-2"
                                required>
                            <label>End Date & Time</label>
                            <input type="datetime-local" name="end_date" id="edit_end_date" class="form-control mb-2" required>
                             <label>Color</label>
                            <input type="color" name="color" id="edit_color" class="form-control form-control-color mb-2">

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

    {{-- View Modal for Everyone --}}
    <div class="modal fade" id="dailyEventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background: linear-gradient(90deg, #fc4a1a, #f7b733);">
                    <h5 class="modal-title">Events on <span id="eventDateTitle"></span></h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="table-white">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                {{-- <th>Color</th> --}}
                                <th>Start Time</th>
                                <th>End Time</th>
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
                                const filtered = events.filter(e => e.start.startsWith(info
                                    .dateStr));
                                const tbody = document.getElementById('dailyEventTable');
                                const title = document.getElementById('eventDateTitle');
                                title.innerText = info.dateStr;
                                tbody.innerHTML = filtered.length ?
                                    filtered.map(e => {
                                        const formatDateTime = dateStr => {
                                            const d = new Date(dateStr);
                                            return `${d.toLocaleDateString()} ${d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                                        };
                                        return `
                                            <tr>
                                                <td>${e.title}</td>
                                                <td>${e.description || ''}</td>

                                                 <td>${new Date(e.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</td>
                                                 <td>${new Date(e.end || e.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</td>
                                            </tr>`;
                                    }).join('')

                                    :
                                    '<tr><td colspan="3" class="text-center">No events</td></tr>';
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

                        const offset = (d) => new Date(d.getTime() - (d.getTimezoneOffset() * 60000))
                            .toISOString().slice(0, 16);
                        document.getElementById('edit_start_date').value = offset(new Date(event
                            .start));
                        document.getElementById('edit_end_date').value = offset(event.end ? new Date(
                            event.end) : new Date(event.start));

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
                            if (response.ok) location.reload();
                            else alert('Error deleting event.');
                        });
                    }
                });
            @endrole
        });
    </script>
@endpush
