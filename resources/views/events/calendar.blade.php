@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Calendar View</h1>
                <p class="text-sm text-gray-500 mt-1">View all scheduled events</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('events.index') }}" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    List View
                </a>
                <a href="{{ route('events.custom-calendar') }}" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h8V3a1 1 0 112 0v1h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 011-1zm11 14V8H4v8h12z" clip-rule="evenodd" />
                    </svg>
                    Custom Calendar
                </a>
                <a href="{{ route('events.upd-calendar') }}" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    UPD Style
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Include FullCalendar.js -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                @foreach($events as $event)
                {
                    id: '{{ $event->id }}',
                    title: '{{ $event->title }}',
                    start: '{{ $event->start_date_time }}',
                    end: '{{ $event->end_date_time }}',
                    url: '{{ route('events.show', $event->id) }}',
                    backgroundColor: '{{ $event->status === "upcoming" ? "#EF4444" : ($event->status === "completed" ? "#6B7280" : "#DC2626") }}',
                    borderColor: '{{ $event->status === "upcoming" ? "#EF4444" : ($event->status === "completed" ? "#6B7280" : "#DC2626") }}',
                },
                @endforeach
            ],
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            }
        });
        calendar.render();
    });
</script>
@endsection