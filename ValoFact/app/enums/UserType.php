<?php

namespace App\enums;



enum UserType: string
{
    case SELLER = 'seller';
    case BUYER = 'buyer';
    case ADMIN = 'admin';
}