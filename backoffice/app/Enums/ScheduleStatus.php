<?php

namespace App\Enums;

enum ScheduleStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Full = 'full';
    case Departed = 'departed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
