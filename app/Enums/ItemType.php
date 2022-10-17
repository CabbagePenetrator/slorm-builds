<?php

namespace App\Enums;

enum ItemType: int
{
    case HELMET = 0;
    case BODY = 1;
    case SHOULDER = 2;
    case GLOVE = 3;
    case BOOT = 4;
    case LEFT_RING = 5;
    case RIGHT_RING = 6;
    case AMULET = 7;
    case BELT = 8;
    case CAPE = 9;
}
