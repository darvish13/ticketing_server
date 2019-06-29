<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Gets All Tickets
     * @return [{Ticket}]
     */
    public function getAll()
    {
        if (auth()->user()->role == 'operator') {
            try {
                $tickets = Ticket::with('user')->get();
                return response()->json($tickets);

            } catch (Illuminate\Database\QueryException $exception) {
                return response()->json(['error' => $exception], 500);
            }

        } else {
            return response()->json(['Error' => 'UnAuthorized'], 401);
        }
    }

    /**
     * Get tickets for logged in user
     * @return [{Ticket}]
     */
    public function getUserTickets()
    {
        try {
            $tickets = Ticket::with('user')->where('user_id', '=', auth()->user()->id)->get();
            return response()->json($tickets);

        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Create new Ticket
     * @return {newTicket}
     */
    public function create()
    {
        try {
            $ticketData = request(['title', 'text']);
            $ticketData['user_id'] = auth()->user()->id;
            $newTicket = Ticket::create($ticketData);

            return response()->json($newTicket);

        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Updates a Ticket
     * @param [ticketId, status]
     * @return {newTicket}
     */
    public function update(Request $request)
    {
        try {
            $ticket = Ticket::find($request->get('ticket_id'));
            $ticket->status = $request->get('status');
            $ticket->save();

            return response()->json($ticket);

        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Deletes a ticket
     * @param ticket_id
     */
    public function delete(Request $request)
    {
        try {
            Ticket::destroy($request->get('ticket_id'));

            return response()->json('Ticket Deleted Successfully');
        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /** 
     * Answer a ticket
     * @param [ticket_id, answer]
     */
    public function answer(Request $request)
    {
        if (auth()->user()->role == 'operator') {

            try {
                $ticket = Ticket::find($request->get('ticket_id'));
                $ticket->answer = $request->get('answer');
                $ticket->status = 'خاتمه یافته';
                $ticket->save();

                return response()->json($ticket);

            } catch (Illuminate\Database\QueryException $exception) {
                return response()->json(['error' => $exception], 500);
            }
        } else {
            return response()->json(['Error' => 'UnAuthorized'], 401);
        }
    }
}
