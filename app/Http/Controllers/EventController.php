<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query()->with('creator');

        // Handle search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('location_details', 'like', "%{$search}%");
            });
        }

        // Handle time frame filter
        if ($request->filled('time_frame')) {
            $timeFrame = $request->input('time_frame');

            if ($timeFrame === 'upcoming') {
                $query->where('status', 'upcoming');
            } elseif ($timeFrame === 'past') {
                $query->where('status', 'completed');
            }
        }

        $events = $query->orderBy('start_date_time', 'desc')->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type' => ['nullable', 'string', 'max:100'],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date', 'after_or_equal:start_date_time'],
            'location' => ['required', 'string', 'max:255'],
            'location_details' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['upcoming', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ]);

        $event = new Event($validated);
        $event->created_by = Auth::id();
        $event->save();

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type' => ['nullable', 'string', 'max:100'],
            'start_date_time' => ['required', 'date'],
            'end_date_time' => ['required', 'date', 'after_or_equal:start_date_time'],
            'location' => ['required', 'string', 'max:255'],
            'location_details' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['upcoming', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Display a calendar view of events.
     */
    public function calendar()
    {
        $events = Event::query()->orderBy('start_date_time', 'asc')->get();

        return view('events.calendar', compact('events'));
    }

    /**
     * Display a custom calendar view of events.
     */
    public function customCalendar()
    {
        $events = Event::query()->orderBy('start_date_time', 'asc')->get();

        return view('events.custom-calendar', compact('events'));
    }

    /**
     * Display a UPD-style calendar view of events.
     */
    public function updCalendar()
    {
        $events = Event::query()->orderBy('start_date_time', 'asc')->get();

        return view('events.upd-calendar', compact('events'));
    }

    /**
     * Export events to iCal format.
     */
    public function exportIcal()
    {
        $events = Event::query()->orderBy('start_date_time', 'asc')->get();

        $calendar = "BEGIN:VCALENDAR\r\n";
        $calendar .= "VERSION:2.0\r\n";
        $calendar .= "PRODID:-//ICSSOC//Club Management System//EN\r\n";
        $calendar .= "CALSCALE:GREGORIAN\r\n";
        $calendar .= "METHOD:PUBLISH\r\n";

        foreach ($events as $event) {
            $calendar .= "BEGIN:VEVENT\r\n";
            $calendar .= "UID:" . $event->id . "@clubmanagementsystem.com\r\n";
            $calendar .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
            $calendar .= "DTSTART:" . $event->start_date_time->format('Ymd\THis\Z') . "\r\n";
            $calendar .= "DTEND:" . $event->end_date_time->format('Ymd\THis\Z') . "\r\n";
            $calendar .= "SUMMARY:" . $event->title . "\r\n";

            if ($event->description) {
                $calendar .= "DESCRIPTION:" . str_replace("\n", "\\n", $event->description) . "\r\n";
            }

            if ($event->location) {
                $calendar .= "LOCATION:" . $event->location;
                if ($event->location_details) {
                    $calendar .= " - " . $event->location_details;
                }
                $calendar .= "\r\n";
            }

            $calendar .= "STATUS:" . strtoupper($event->status) . "\r\n";
            $calendar .= "END:VEVENT\r\n";
        }

        $calendar .= "END:VCALENDAR";

        return response($calendar)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="events.ics"');
    }

    /**
     * Add functionality for users to RSVP to events.
     */
    public function attend(Request $request, Event $event)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:attending,maybe,not_attending'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $event->attendances()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'status' => $validated['status'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->route('events.show', $event)
            ->with('success', 'Your attendance status has been updated.');
    }

    /**
     * Show attendees for an event.
     */
    public function attendees(Event $event)
    {
        $this->authorize('viewAttendees', $event);

        $attendees = $event->attendances()->with('user')->get();

        return view('events.attendees', compact('event', 'attendees'));
    }
}
