<?php

namespace App\Repositories;



class FacultyRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Faculty";
    }
}
