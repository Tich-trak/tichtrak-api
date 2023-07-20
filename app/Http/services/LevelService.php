<?php

namespace App\Http\Services;

use App\Repositories\LevelRepository;

class LevelService extends BaseService {

    public function __construct(private LevelRepository $level) {
        parent::__construct($level, 'level');
    }
}
