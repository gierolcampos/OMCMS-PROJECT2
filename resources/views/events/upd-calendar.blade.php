@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/upd-calendar.css') }}">
@endsection

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between space-y-4 md:space-y-0 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Calendar of Events</h1>
                <p class="text-sm text-gray-500 mt-1">UPD Style Calendar</p>
            </div>
            <div class="flex items-center space-x-3">
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
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Calendar Section -->
            <div class="md:w-1/3">
                <!-- Search Bar -->
                <div class="mb-4">
                    <div class="flex">
                        <input type="text" placeholder="Search Events..." class="w-full border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none">
                        <button type="button" class="bg-[#c21313] text-white px-4 py-2 rounded-r-md text-sm hover:bg-[#a51010] transition duration-200">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Month Navigation -->
                <div class="flex items-center justify-between mb-4">
                    <select id="monthSelect" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>

                    <div class="flex space-x-1">
                        <button id="prevMonth" class="p-1 rounded-md hover:bg-gray-100 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button id="nextMonth" class="p-1 rounded-md hover:bg-gray-100 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-grid border border-gray-200 rounded-md overflow-hidden">
                    <!-- Days of Week -->
                    <div class="grid grid-cols-7 text-center text-xs font-medium text-gray-500 bg-gray-50 border-b border-gray-200">
                        <div class="py-2">M</div>
                        <div class="py-2">T</div>
                        <div class="py-2">W</div>
                        <div class="py-2">T</div>
                        <div class="py-2">F</div>
                        <div class="py-2">S</div>
                        <div class="py-2">S</div>
                    </div>

                    <!-- Calendar Days -->
                    <div id="calendarDays" class="grid grid-cols-7">
                        <!-- Calendar days will be populated by JavaScript -->
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-2">
                    <a href="#" class="action-button block w-full text-center bg-gray-800 text-white py-2 px-4 rounded-md text-sm hover:bg-gray-700 transition duration-200">
                        Submission Guidelines
                    </a>
                    <a href="{{ route('events.index') }}" class="action-button block w-full text-center bg-gray-600 text-white py-2 px-4 rounded-md text-sm hover:bg-gray-500 transition duration-200">
                        See all events
                    </a>
                </div>
            </div>

            <!-- Events List Section -->
            <div class="md:w-2/3">
                <div id="eventsList" class="space-y-6">
                    <!-- Events will be populated by JavaScript -->
                </div>

                <!-- No Events Message (hidden by default) -->
                <div id="noEventsMessage" class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">No events found</h3>
                    <p class="text-gray-500">There are no events scheduled for the selected date.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sample events data (will be replaced with actual data from backend)
        const events = @json($events);

        // Current date state
        let currentDate = new Date();
        let selectedDate = null;

        // Initialize calendar
        updateMonthSelect();
        renderCalendar(currentDate);
        renderEventsList(events);

        // Event listeners for month navigation
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            updateMonthSelect();
            renderCalendar(currentDate);
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            updateMonthSelect();
            renderCalendar(currentDate);
        });

        // Event listener for month select
        document.getElementById('monthSelect').addEventListener('change', function() {
            const selectedMonth = parseInt(this.value);
            currentDate.setMonth(selectedMonth);
            renderCalendar(currentDate);
        });

        // Update month select to match current date
        function updateMonthSelect() {
            document.getElementById('monthSelect').value = currentDate.getMonth();
        }

        // Function to render calendar
        function renderCalendar(date) {
            const year = date.getFullYear();
            const month = date.getMonth();

            // Get first day of month and total days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const totalDays = lastDay.getDate();

            // Get day of week for first day (0 = Sunday, so we adjust for Monday start)
            let firstDayOfWeek = firstDay.getDay() - 1;
            if (firstDayOfWeek < 0) firstDayOfWeek = 6; // Sunday becomes last day

            // Get days from previous month
            const prevMonthLastDay = new Date(year, month, 0).getDate();

            // Clear calendar
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';

            // Add days from previous month
            for (let i = 0; i < firstDayOfWeek; i++) {
                const dayNum = prevMonthLastDay - firstDayOfWeek + i + 1;
                const dayEl = createDayElement(dayNum, 'other-month', new Date(year, month - 1, dayNum));
                calendarDays.appendChild(dayEl);
            }

            // Add days from current month
            const today = new Date();
            for (let i = 1; i <= totalDays; i++) {
                const isToday = today.getDate() === i &&
                                today.getMonth() === month &&
                                today.getFullYear() === year;

                const currentDateObj = new Date(year, month, i);
                const hasEvents = events.some(event => {
                    const eventDate = new Date(event.start_date_time);
                    return eventDate.getDate() === i &&
                           eventDate.getMonth() === month &&
                           eventDate.getFullYear() === year;
                });

                const classes = [];
                if (isToday) classes.push('today');
                if (hasEvents) classes.push('has-events');
                if (selectedDate &&
                    selectedDate.getDate() === i &&
                    selectedDate.getMonth() === month &&
                    selectedDate.getFullYear() === year) {
                    classes.push('selected');
                }

                const dayEl = createDayElement(i, classes.join(' '), currentDateObj);
                calendarDays.appendChild(dayEl);
            }

            // Add days from next month
            const totalCells = 42; // 6 rows of 7 days
            const remainingCells = totalCells - (firstDayOfWeek + totalDays);

            for (let i = 1; i <= remainingCells; i++) {
                const dayEl = createDayElement(i, 'other-month', new Date(year, month + 1, i));
                calendarDays.appendChild(dayEl);
            }
        }

        // Function to create a day element
        function createDayElement(dayNum, classes, dateObj) {
            const dayEl = document.createElement('div');
            dayEl.className = `calendar-day ${classes}`;
            dayEl.textContent = dayNum;

            dayEl.addEventListener('click', function() {
                // Remove selected class from all days
                document.querySelectorAll('.calendar-day.selected').forEach(el => {
                    el.classList.remove('selected');
                });

                // Add selected class to clicked day
                dayEl.classList.add('selected');

                // Update selected date
                selectedDate = dateObj;

                // Filter events for the selected date
                filterEventsByDate(dateObj);
            });

            return dayEl;
        }

        // Function to filter events by date
        function filterEventsByDate(date) {
            const filteredEvents = events.filter(event => {
                const eventDate = new Date(event.start_date_time);
                return eventDate.getDate() === date.getDate() &&
                       eventDate.getMonth() === date.getMonth() &&
                       eventDate.getFullYear() === date.getFullYear();
            });

            renderEventsList(filteredEvents);
        }

        // Function to render events list
        function renderEventsList(eventsList) {
            const eventsListEl = document.getElementById('eventsList');
            const noEventsMessage = document.getElementById('noEventsMessage');

            // Clear events list
            eventsListEl.innerHTML = '';

            if (eventsList.length === 0) {
                eventsListEl.classList.add('hidden');
                noEventsMessage.classList.remove('hidden');
                return;
            }

            eventsListEl.classList.remove('hidden');
            noEventsMessage.classList.add('hidden');

            // Sort events by start time
            eventsList.sort((a, b) => new Date(a.start_date_time) - new Date(b.start_date_time));

            // Add events to list with staggered animation
            eventsList.forEach((event, index) => {
                setTimeout(() => {
                    const eventCard = createEventCard(event);
                    eventCard.classList.add('fade-in');
                    eventsListEl.appendChild(eventCard);
                }, index * 100);
            });
        }

        // Function to create an event card
        function createEventCard(event) {
            const eventDate = new Date(event.start_date_time);
            const endDate = new Date(event.end_date_time);

            const card = document.createElement('div');
            card.className = 'event-card flex cursor-pointer';
            card.setAttribute('data-event-id', event.id);

            // Random placeholder images for demo
            const placeholderImages = [
                'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250&q=80',
                'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250&q=80',
                'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250&q=80',
                'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=250&q=80'
            ];

            const randomImage = placeholderImages[Math.floor(Math.random() * placeholderImages.length)];

            card.innerHTML = `
                <div class="event-image w-1/4">
                    <img src="${randomImage}" alt="${event.title}" class="w-full h-full object-cover">
                </div>
                <div class="p-4 w-3/4">
                    <div class="event-date mb-2">
                        <span class="text-[#c21313] font-medium">
                            ${formatDate(eventDate)} | ${formatTime(eventDate)} - ${formatTime(endDate)}
                        </span>
                    </div>
                    <h3 class="event-title text-lg mb-2">${event.title}</h3>
                </div>
            `;

            // Add click event to navigate to event details
            card.addEventListener('click', function() {
                window.location.href = `/events/${event.id}`;
            });

            return card;
        }

        // Helper function to format date
        function formatDate(date) {
            const options = { month: 'short', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // Helper function to format time
        function formatTime(date) {
            const options = { hour: 'numeric', minute: '2-digit', hour12: true };
            return date.toLocaleTimeString('en-US', options);
        }
    });
</script>
@endsection
