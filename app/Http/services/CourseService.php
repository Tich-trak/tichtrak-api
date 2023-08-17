<?php

namespace App\Http\Services;

use App\Repositories\CourseRepository;

class CourseService extends BaseService {

    public function __construct(private CourseRepository $course) {
        parent::__construct($course, 'course');
    }
}
