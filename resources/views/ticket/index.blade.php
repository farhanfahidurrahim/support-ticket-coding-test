@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tickets</h1>

        @foreach ($tickets as $ticket)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $ticket->subject }}</h5>
                    <p class="card-text">{{ $ticket->message }}</p>
                    <p class="card-text">Status: {{ $ticket->status }}</p>

                    @if (auth()->user()->role === 'admin' && $ticket->status === 'open')
                        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary">Close Ticket</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
