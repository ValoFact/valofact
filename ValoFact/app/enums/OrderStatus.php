<?php

namespace App\enums;




enum OrderStatus: string
{
    case AVAILABLE = 'available';
    case SOLD = 'sold';
    case EXPIRED = 'expired';
}