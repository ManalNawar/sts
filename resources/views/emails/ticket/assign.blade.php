@extends('emails.emaillayout')

@section('content')
<p>You have a new ticket assigned to you!</p>

<p>Title: {{ $ticket->ticket_title }}</p>

<p>Content:  {{ $ticket->ticket_content }}</p>

<p>At:  {{ $ticket->location->location_name }}</p>

<p>in:  {{ $ticket->category->category_name }}</p>

<p>Requested by:  {{ $ticket->requested_by_user->name }}</p>

@endsection