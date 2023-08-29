<?php

namespace App\Http\Services;

use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Collection;

class CourseService extends BaseService {

    public function __construct(
        private CourseRepository $course,
        private InstitutionService $institutionService,
        private FacultyService $facultyService,
        private DepartmentService $departmentService
    ) {
        parent::__construct($course, 'course');
    }

    public function findInstitutionCourses(string $institutionId): Collection {
        $this->institutionService->findById($institutionId);

        $courses = $this->course->whereHas('level.institution', function ($query) use ($institutionId) {
            $query->where('id', $institutionId);
        })->get();

        return $courses;
    }

    public function findFacultyCourses(string $facultyId): Collection {
        $this->facultyService->findById($facultyId);

        $courses = $this->course->whereHas('level.institution.faculties', function ($query) use ($facultyId) {
            $query->where('id', $facultyId);
        })->get();

        return $courses;
    }

    public function findDepartmentCourses(string $departmentId): Collection {
        $this->departmentService->findById($departmentId);

        $courses = $this->course->whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->get();

        return $courses;
    }
}
