<?php

namespace App\Http\Services;

use App\Repositories\StudentRepository;

class StudentService extends BaseService {

    public function __construct(private StudentRepository $student) {
        parent::__construct($student, 'student');
    }
}
