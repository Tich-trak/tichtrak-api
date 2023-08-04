<?php

namespace App\Http\Services;

use App\Repositories\DepartmentRepository;

class DepartmentService extends BaseService {

    public function __construct(private DepartmentRepository $department) {
        parent::__construct($department, 'department');
    }
}
