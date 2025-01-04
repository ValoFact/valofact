<?php


namespace App\enums;


enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETE = 'complete';
    case FAILED = 'failed';
}