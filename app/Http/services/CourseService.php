<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Repositories\CourseRepository;

class CourseService extends BaseService {

    public function __construct(
        private CourseRepository $course,
        private InstitutionService $institutionService,
        private DepartmentService $departmentService
    ) {
        parent::__construct($course, 'course');
    }

    public function findInstitutionCourses(string $institutionId) {
        $institution = $this->institutionService->findById($institutionId);
        if (!$institution) throw new ErrorException('invalid institution id provided');

        $courses = $this->course->whereHas('level.institution', function ($query) use ($institutionId) {
            $query->where('id', $institutionId);
        })->get();

        return $courses;
    }

    public function findDepartmentCourses(string $departmentId) {
        $department = $this->departmentService->findById($departmentId);
        if (!$department) throw new ErrorException('invalid department id provided');

        $courses = $this->course->whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->get();

        return $courses;
    }
}
