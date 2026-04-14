<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Pending = 'pending';
    case Issued = 'issued';
    case Used = 'used';
    case Cancelled = 'cancelled';
}
