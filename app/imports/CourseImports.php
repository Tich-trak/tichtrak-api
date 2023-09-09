<?php

namespace App\Imports;

use App\Models\Course;
use Symfony\Component\Uid\Ulid;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourseImports implements ToModel, WithHeadingRow {
    /**
     * @param array $row
     *
     * @return Course|null
     */
    public function model(array $row) {

        return new Course([
            'level_id' => $row['level_id'],
            'name' => $row['name'],
            'alias' => $row['alias'],
            'code' => $row['code'],
            'description' => $row['description'],
        ]);
    }
}