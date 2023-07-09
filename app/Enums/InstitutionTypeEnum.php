<?php

namespace App\Enums;

enum InstitutionTypeEnum: string {
    case College = 'college';
    case Polytechnic = 'polytechnic';
    case University = 'university';
    case Others = 'others';
}