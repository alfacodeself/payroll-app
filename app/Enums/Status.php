<?php

namespace App\Enums;

enum Status : string {
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DEACTIVATED = 'deactivated';

    case EXPIRED = 'expired';
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case ACCEPTED = 'accepted';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case DECLINED = 'declined';

    case OPENED = 'opened';
    case CLOSED = 'closed';

    case PAID = 'paid';
    case UNPAID = 'unpaid';
}