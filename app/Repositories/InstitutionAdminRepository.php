<?php

namespace App\Repositories;



class InstitutionAdminRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\InstitutionAdmin";
    }
}
