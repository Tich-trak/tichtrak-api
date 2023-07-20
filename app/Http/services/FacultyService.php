<?php

namespace App\Http\Services;

use App\Repositories\FacultyRepository;

class FacultyService extends BaseService {

    public function __construct(private FacultyRepository $faculty) {
        parent::__construct($faculty, 'faculty');
    }
}
