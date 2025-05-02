@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Event Details</h1>
                <p class="text-sm text-gray-500 mt-1">View event information</p>
            </div>
            <a href="{{ route('events.index') }}" class="bg-white border border-gray-300 text-gray-700 text-sm py-2 px-4 rounded-md flex items-center transition duration-200 hover:bg-gray-50 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Events
            </a>
        </div>
        
        <!-- Event Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 bg-red-100 rounded-md flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">{{ $event->title }}</h2>
                                <p class="text-sm text-gray-500 mt-1">{{ $event->event_type ?? 'Event' }}</p>
                            </div>
                            <div>
                                @if($event->status === 'upcoming')
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                    Upcoming
                                </span>
                                @elseif($event->status === 'completed')
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                    Completed
                                </span>
                                @else
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-800">
                                    Cancelled
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        @if(Auth::user()->is_admin)
                        <div class="flex items-center gap-3 mt-4">
                            <a href="{{ route('events.edit', $event) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit Event
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-white border border-red-300 rounded-md text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Delete Event
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Event Details -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Event Information</h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Description</h4>
                            <div class="text-gray-700 prose">
                                {!! nl2br(e($event->description)) !!}
                            </div>
                        </div>
                        
                        @if($event->notes)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Additional Notes</h4>
                            <div class="text-gray-700 prose">
                                {!! nl2br(e($event->notes)) !!}
                            </div>
                        </div>
                        @endif
                        
                        <div class="mt-6 text-sm text-gray-500">
                            <p>Event created by: {{ $event->creator ? $event->creator->name : 'Unknown user' }}</p>
                            <p>Created: {{ $event->created_at ? $event->created_at->format('M d, Y') : 'Unknown date' }}</p>
                            <p>Last updated: {{ $event->updated_at ? $event->updated_at->format('M d, Y') : 'Unknown date' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Event RSVP Form -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Are you attending?</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $attendance = $event->attendances()->where('user_id', Auth::id())->first();
                            $status = $attendance ? $attendance->status : null;
                            $comment = $attendance ? $attendance->comment : '';
                        @endphp
                        
                        <form action="{{ route('events.attend', $event) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="attending" {{ $status === 'attending' ? 'checked' : '' }} class="form-radio h-5 w-5 text-red-600">
                                        <span class="ml-2 text-gray-700">I'm attending</span>
                                    </label>
                                    
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="maybe" {{ $status === 'maybe' ? 'checked' : '' }} class="form-radio h-5 w-5 text-yellow-500">
                                        <span class="ml-2 text-gray-700">Maybe</span>
                                    </label>
                                    
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="not_attending" {{ $status === 'not_attending' ? 'checked' : '' }} class="form-radio h-5 w-5 text-gray-600">
                                        <span class="ml-2 text-gray-700">I'm not attending</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                                <textarea name="comment" id="comment" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">{{ $comment }}</textarea>
                            </div>
                            
                            <button type="submit" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300">
                                Save Response
                            </button>
                            
                            @if(Auth::user()->is_admin || $event->created_by === Auth::id())
                            <a href="{{ route('events.attendees', $event) }}" class="ml-4 px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                View Attendees
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Event Meta -->
            <div>
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Date & Time</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">
                                    {{ isset($event->start_date_time) ? $event->start_date_time->format('l, F j, Y') : 'Date not set' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ isset($event->start_date_time) ? $event->start_date_time->format('g:i A') : '' }}
                                    {{ isset($event->start_date_time) && isset($event->end_date_time) ? '-' : '' }}
                                    {{ isset($event->end_date_time) ? $event->end_date_time->format('g:i A') : '' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ isset($event->start_date_time) && isset($event->end_date_time) ? 'Duration: ' . $event->start_date_time->diffForHumans($event->end_date_time, true) : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-800">Location</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $event->location ?? 'Location not set' }}</p>
                                @if($event->location_details)
                                <p class="text-sm text-gray-500 mt-1">{{ $event->location_details }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 