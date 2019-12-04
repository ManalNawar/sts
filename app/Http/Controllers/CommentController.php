<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Comment;
use App\Ticket;
use App\Mail\TicketNewComment;
use Carbon\Carbon;

class CommentController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'comment_body' => 'required',
    ]);
    $comment = new Comment;
    $comment->body = $request->get('comment_body');
    $comment->user()->associate($request->user());
    $ticket = Ticket::find($request->get('ticket_id'));
    $ticket->comments()->save($comment);
    $ticketAgent = $ticket->user;
    $requested_by = $ticket->requested_by_user;
    if ($requested_by) {
      if (App::environment('production')) {
        \Mail::to($requested_by)->send(new TicketNewComment($ticket, $comment));
      }
    }

    if ($ticketAgent->isEmpty()) {
      return back();
    } else {
      if (App::environment('production')) {
        \Mail::to($ticketAgent)->send(new TicketNewComment($ticket, $comment));
      }
    }
    return back();
  }

  public function replyStore(Request $request)
  {
    $request->validate([
      'comment_body' => 'required',
    ]);
    $reply = new Comment();
    $reply->body = $request->get('comment_body');
    $reply->user()->associate($request->user());
    $reply->parent_id = $request->get('comment_id');
    $ticket = Ticket::find($request->get('ticket_id'));

    $ticket->comments()->save($reply);

    return back();
  }
  public function destroyComment($id)
  {
    $comment =  Comment::findOrfail($id);
    $currentTime = Carbon::now();
    $updatedAt = $comment->updated_at;
    $diffInMinutes = $currentTime->diffInMinutes($updatedAt, true);
    if ($diffInMinutes < 5) {
      $comment->deleted_at = $currentTime;
      $comment->body = 'this comment was deleted';
      $comment->save();
      return back()->with('success', 'comment was deleted');
    } else {
      return back()->with('errors', 'this comment cannot be deleted');
    }
  }
}
