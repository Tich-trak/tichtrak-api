<?php

namespace App\Http\Services;

use App\Repositories\PasswordRepository;



class PasswordService extends BaseService {

    public function __construct(private PasswordRepository $password) {
        parent::__construct($password);
    }
}