@extends('layouts.app')
@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold">Events</h1>
    <p>Welcome to the Events page.</p>

    @if(Auth::user()->is_admin)
        <a href="{{ route('events.add') }}">
            <button>add event</button>
        </a>
    @endif

</div>
@endsection 