<?php

namespace App\Http\Services;

use App\Repositories\InstitutionRepository;



class InstitutionService extends BaseService {

    public function __construct(private InstitutionRepository $institution) {
        parent::__construct($institution);
    }
}
