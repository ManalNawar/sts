<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
use App\Location;
use App\Status;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tickets = Ticket::all();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('category_name','id');
        $locations = Location::all()->pluck('location_name','id');
        return view('ticket.create', compact('categories','locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'ticket_title'=>'required',
          'ticket_content'=> 'required',
        ]);
        $ticket = new Ticket;

        $ticket->ticket_title = $request->ticket_title;
        $ticket->ticket_content = $request->ticket_content;
        $ticket->category_id = $request->category_id;

        $ticket->save();
        return redirect('/ticket')->with('success', 'Stock has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $tickets = Ticket::find($id);
        return view('ticket.show', compact('tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $ticket = Ticket::find($id);
      return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $ticket = Ticket::find($id);
      $ticket->ticket_title = $request->ticket_title;
      $ticket->ticket_content = $request->ticket_content;
      $ticket->save();

      return redirect('/ticket')->with('success', 'Ticket has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}