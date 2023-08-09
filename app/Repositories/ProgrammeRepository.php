<?php

namespace App\Repositories;



class ProgrammeRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Programme";
    }
}
