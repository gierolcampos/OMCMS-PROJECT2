@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Calendar View</h1>
                <p class="text-sm text-gray-500 mt-1">View all scheduled events</p>
            </div>
            <a href="{{ route('events.index') }}" class="border border-gray-400 hover:bg-gray-500 hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 inline" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to List View
            </a>
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