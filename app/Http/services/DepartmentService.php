<?php

namespace App\Http\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Support\Facades\DB;

class DepartmentService extends BaseService {

    public function __construct(private DepartmentRepository $department) {
        parent::__construct($department, 'department');
    }

    public function create(array $request): Department {
        $department =  DB::transaction(function () use ($request) {
            $department = $this->department->create($request);

            if (array_key_exists('course_ids', $request))
                $department->courses->attach($request['course_ids']);

            return $department;
        });

        return $department;
    }
}
