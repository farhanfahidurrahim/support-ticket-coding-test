<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketIsOpen;
use App\Mail\TicketIsClose;
use App\Models\TicketIssue;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->get();
        return view('dashboard', compact('tickets'));
    }

    public function create()
    {
        return view('ticket.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'body' => $request->body,
            'status' => 'open',
        ]);

        return redirect()->route('dashboard');
    }


    public function show(string $id)
    {
        $ticket = Ticket::with('getTicketIssue')->find($id);

        $user = auth()->user();
        if ($user->role === 'admin') {
            $issues = $ticket->getTicketIssue;
        } else {
            $issues = $ticket->getTicketIssue->where('user_id', $user->id);
            Mail::to($ticket->getUser->email)->send(new TicketIsOpen($ticket));
        }

        return view('ticket.show', compact('ticket', 'issues'));
    }

    public function issues(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        TicketIssue::create([
            'user_id' => auth()->id(),
            'ticket_id' => $request->ticket_id,
            'description' => $request->description,
            'admin_respond' => $request->admin_respond,
        ]);

        return redirect()->route('dashboard');
    }

    public function issuesRespond(Request $request, $id)
    {
        $ticketIssue = TicketIssue::findOrFail($id);
        $ticketIssue->admin_respond = $request->admin_respond;
        $ticketIssue->save();

        return redirect()->route('dashboard');
    }

    public function statusChange(Request $request)
    {
        $ticket = Ticket::findOrFail($request->id);
        if ($request->status === 'close') {
            Mail::to($ticket->getUser->email)->send(new TicketIsClose($ticket));
        }
        $ticket->status = $request->status;
        $ticket->save();

        return response()->json(['success' => true]);
    }
}
