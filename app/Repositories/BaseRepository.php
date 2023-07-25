<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository as Repository;


abstract class BaseRepository extends Repository {

    public abstract function model();

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->model->filter()->get();
    }

    /**
     * @param string $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column = 'id', $direction = 'desc') {
        return $this->model->orderBy($column, $direction);
    }

    /**
     * @param array $columns
     * @param array $data
     * @return mixed
     */

    public function updateOne($data, $query) {
        try {
            return tap($this->model::findWhere($query)->first())->update($data)->fresh();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function updateById($data, $id) {
        try {
            return tap($this->model::where('id', $id)->first())->update($data)->fresh();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function _delete($column, $value) {
        return $this->model->where($column, '=', $value)->delete();
    }
}
