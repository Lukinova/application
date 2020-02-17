<?php

namespace App;

/**
 * Class Ticket
 */
class Ticket extends Collection
{
    protected $table = 'tickets';
    protected $fillable = ['user_name', 'user_email', 'text', 'status'];
}

