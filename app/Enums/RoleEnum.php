<?php

namespace App\Enums;

enum RoleEnum: string {
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Student = 'student';
}
