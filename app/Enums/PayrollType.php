<?php

namespace App\Enums;

enum PayrollType : string {
    case ADDITIONAL = 'additional';
    case DEDUCTION = 'deduction';
}