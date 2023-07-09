<?php

namespace App\Enums;

enum StatusEnum: string {
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}