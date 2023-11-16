<?php

namespace App\Http\Services;

use App\Repositories\NotificationRepository;

class NotificationService extends BaseService {

    public function __construct(private NotificationRepository $notification) {
        parent::__construct($notification, 'notification');
    }
}
