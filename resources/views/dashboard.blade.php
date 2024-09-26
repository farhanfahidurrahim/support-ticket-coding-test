<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between">
                        <div>
                            {{ __('Ticket List') }}
                        </div>
                        <div>
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('ticket.create') }}" class="btn btn-sm btn-primary">Add New</a>
                            @endif
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Body</th>
                                <th scope="col">Issue</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->body }}</td>
                                    @if ($ticket->getTicketIssue->isNotEmpty())
                                        @if (auth()->user()->role === 'admin')
                                            <td>{{ 'Issue Found' }}
                                            </td>
                                        @else
                                            <td>{{ 'Submitted' }}</td>
                                        @endif
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td>
                                        @if (auth()->user()->role === 'admin')
                                            <button class="btn btn-sm btn-primary btn-toggle-status"
                                                data-id="{{ $ticket->id }}" data-status="{{ $ticket->status }}">
                                                {{ $ticket->status === 'open' ? 'Close' : 'Open' }}
                                            </button>
                                            (click btn)
                                        @else
                                            {{ $ticket->status }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('ticket.open', $ticket->id) }}"
                                            class="btn btn-success">Open/View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-toggle-status').click(function() {
            let ticketId = $(this).data('id');
            let currentStatus = $(this).data('status');
            let newStatus = currentStatus === 'open' ? 'close' : 'open';

            $.ajax({
                url: `/ticket/status-change/${ticketId}`,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: ticketId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        $(`button[data-id='${ticketId}']`).text(newStatus === 'open' ?
                            'Close' : 'Open');
                        $(`button[data-id='${ticketId}']`).data('status', newStatus);
                    } else {
                        alert('failed udpate');
                    }
                },
            });
        });
    });
</script>
