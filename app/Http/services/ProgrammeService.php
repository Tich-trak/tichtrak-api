<?php

namespace App\Http\Services;

use App\Repositories\ProgrammeRepository;

class ProgrammeService extends BaseService {

    public function __construct(private ProgrammeRepository $programme) {
        parent::__construct($programme, 'programme');
    }
}
