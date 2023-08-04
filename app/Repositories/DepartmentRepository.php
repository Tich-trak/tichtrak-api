<?php

namespace App\Repositories;



class DepartmentRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Department";
    }
}
