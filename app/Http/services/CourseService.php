<?php

namespace App\Http\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseService extends BaseService {

    public function __construct(private CourseRepository $course) {
        parent::__construct($course, 'course');
    }

    public function findInstitutionCourses(string $institutionId) {
        return null;
    }

    public function findDepartmentCourses(string $departmentId) {
        return null;
    }
}
