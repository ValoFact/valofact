<?php

namespace App\enums;




enum BidStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case OUTBID = 'outbid';
}