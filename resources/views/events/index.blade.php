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

<style>
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection 