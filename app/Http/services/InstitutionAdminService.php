<?php

namespace App\Http\Services;

use App\Repositories\InstitutionAdminRepository;



class InstitutionAdminService extends BaseService {

    public function __construct(private InstitutionAdminRepository $institutionAdmin) {
        parent::__construct($institutionAdmin, 'admin');
    }
}
