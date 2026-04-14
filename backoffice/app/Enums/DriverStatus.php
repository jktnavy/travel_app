<?php

namespace App\Enums;

enum DriverStatus: string
{
    case Active = 'active';
    case OnLeave = 'on_leave';
    case Inactive = 'inactive';
}
