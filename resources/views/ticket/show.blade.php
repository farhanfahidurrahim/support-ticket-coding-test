<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <h2>Ticket #{{ $ticket->id }}</h2>

        <div class="card">
            <div class="card-header">
                <h5>{{ $ticket->issue }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
                <p><strong>Description:</strong> {{ $ticket->body }}</p>

                <hr>

                @if ($ticket->status != 'close')
                    @if (auth()->user()->role == 'admin')

                        @if ($issues->isEmpty())
                            <p>No issue</p>
                        @else
                            @foreach ($issues as $issue)
                                <div class="form-group mt-3">
                                    <label for="description">Issue #{{ $loop->iteration }}:</label>

                                    <textarea name="description" class="form-control" rows="3" readonly>{{ $issue->description }}</textarea>

                                    <label for="response">Admin Response:</label>
                                    <form action="{{ route('ticket.issuesRespond', $issue->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="admin_respond" class="form-control" rows="3">{{ $issue->admin_respond }}</textarea>
                                        <button type="submit" class="btn btn-primary mt-2">Reply</button>
                                    </form>
                            @endforeach
                        @endif
                    @else
                        @if ($issues->isEmpty())
                            <form method="POST" action="{{ route('ticket.issues') }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">


                                <div class="form-group mt-3">
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Submit/Update</button>
                            </form>
                        @else
                            Already Issue Submitted!
                        @endif
                    @endif
                @else
                    <div class="alert alert-warning mt-3">
                        Sorry! ticket closed
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Tickets</a>
        </div>
    </div>
</x-app-layout>
