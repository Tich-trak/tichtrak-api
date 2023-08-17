<?php

namespace App\Repositories;



class CourseRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Course";
    }
}
