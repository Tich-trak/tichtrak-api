<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImports implements ToModel, WithHeadingRow {
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row) {

        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'level_id' => $row['level_id'],
            'alias' => $row['alias'],
            'code' => $row['code'],
            'description' => $row['description'],
        ]);
    }
}
