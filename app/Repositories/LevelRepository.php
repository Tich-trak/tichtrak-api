<?php

namespace App\Repositories;



class LevelRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Level";
    }
}
