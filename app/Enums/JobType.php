<?php

namespace App\Enums;

enum JobType : string {
    case DAILY = 'daily';
    case PIECEWORK = 'piecework';
}