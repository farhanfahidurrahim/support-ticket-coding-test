<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container">
        <h2>Create New Ticket</h2>

        <div class="card">
            <div class="card-header">
                <h5>Create a New Support Ticket</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ticket.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="4" required></textarea>
                        @error('body')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Ticket</button>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Tickets</a>
        </div>
    </div>
</x-app-layout>
