<?php

namespace App\Repositories;



class NotificationRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model() {
        return  "App\Models\Notification";
    }
}
