<?php

namespace App\Http\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService {

    public function __construct(private UserRepository $user) {
        parent::__construct($user, 'user');
    }
}
