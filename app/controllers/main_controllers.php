<?php

use App\Ticket;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //
    $ticket = new Ticket();
    if (!($_POST['text'] && $_POST['user_email'] && $_POST['user_name'])) header('Location: /');
    $ticket->text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
    $ticket->user_email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL);
    $ticket->user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_STRING);
    $ticket->status = 0;

    $ticket->save();

    header('Location: /');
}


$tickets = (new Ticket())->paginate(3);
//$tickets = (new Ticket())->get([2, 5]);

\App\view('index', ['tickets' => $tickets->get(), 'pagination' => $tickets->pagination()]);