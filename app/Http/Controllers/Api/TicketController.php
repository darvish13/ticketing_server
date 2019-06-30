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
                $tickets = Ticket::with('user')
                    ->orderBy('updated_at', 'desc')
                    ->get();

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
            $tickets = Ticket::with('user')
                ->where('user_id', '=', auth()->user()->id)
                ->orderBy('updated_at', 'desc')
                ->get();
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

            $newTicket['user'] = $newTicket->user;

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
    public function update()
    {
        try {
            $ticket = Ticket::find(request('id'));
            $ticket->status = request('status');
            $ticket->save();

            try {
                $tickets = Ticket::with('user')
                    ->where('user_id', '=', auth()->user()->id)
                    ->orderBy('updated_at', 'desc')
                    ->get();
                return response()->json($tickets);
            } catch (Illuminate\Database\QueryException $exception) {
                return response()->json(['error' => $exception], 500);
            }
        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Deletes a ticket
     * @param ticket_id
     */
    public function delete()
    {
        try {
            Ticket::destroy(request('id'));

            try {
                $tickets = Ticket::with('user')
                    ->where('user_id', '=', auth()->user()->id)
                    ->orderBy('updated_at', 'desc')
                    ->get();
                return response()->json($tickets);
            } catch (Illuminate\Database\QueryException $exception) {
                return response()->json(['error' => $exception], 500);
            }
        } catch (Illuminate\Database\QueryException $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /** 
     * Answer a ticket
     * @param [ticket_id, answer]
     */
    public function answer()
    {
        if (auth()->user()->role == 'operator') {

            try {
                $ticket = Ticket::find(request('id'));
                $ticket->answer = request('answer');
                $ticket->status = 'خاتمه یافته';
                $ticket->save();

                try {
                    $tickets = Ticket::with('user')
                        ->orderBy('updated_at', 'desc')
                        ->get();

                    return response()->json($tickets);
                } catch (Illuminate\Database\QueryException $exception) {
                    return response()->json(['error' => $exception], 500);
                }
                
            } catch (Illuminate\Database\QueryException $exception) {
                return response()->json(['error' => $exception], 500);
            }
        } else {
            return response()->json(['Error' => 'UnAuthorized'], 401);
        }
    }
}