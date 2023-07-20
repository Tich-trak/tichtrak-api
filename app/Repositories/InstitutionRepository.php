<?php

namespace App\Repositories;



class InstitutionRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Institution";
    }
}
