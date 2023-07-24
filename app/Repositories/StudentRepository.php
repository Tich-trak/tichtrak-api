<?php

namespace App\Repositories;



class StudentRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return "App\Models\Student";
    }
}
