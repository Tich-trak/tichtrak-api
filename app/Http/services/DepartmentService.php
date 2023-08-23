<?php

namespace App\Http\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use ErrorException;
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

    public function addCourses(string $id, array $request): Department {
        $department = $this->department->find($id);
        if (!$department) throw new ErrorException('department not found');

        $departmentCourses = $department->courses;
        $courseIds = collect($request['course_ids']);

        $courseIds = $courseIds->map(function ($courseId) use ($departmentCourses) {
            if ($departmentCourses->contains($courseId))
                throw new ErrorException('course already exist in department', 409);

            return $courseId;
        });

        $department->courses()->attach($courseIds);
        return $department->fresh();
    }

    public function removeCourses(string $id, object|array $request): Department {
        $department = $this->department->find($id);
        if (!$department) throw new ErrorException('department not found');

        $departmentCourses = $department->courses;
        $courseIds = collect($request['course_ids']);

        $courseIds = $courseIds->map(function ($courseId) use ($departmentCourses) {
            if (!$departmentCourses->contains($courseId))
                throw new ErrorException('course does not exist in department');

            return $courseId;
        });

        $department->courses()->detach($courseIds);
        return $department->fresh();
    }
}
