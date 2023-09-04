<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository as Repository;


abstract class BaseRepository extends Repository {

    public abstract function model();

    /**
     * Bulk create records.
     *
     * @param array $data
     * @return bool
     */
    public function bulkCreate(array $data) {
        return $this->model->insert($data);
    }

    /**
     * THIS FUNCTION ACCEPTS QUERY FILTER BY DEFAULT
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
     * @param array $data
     * @param array $query
     * @return mixed
     */
    public function updateOne(array $data, array $query) {
        try {
            return tap($this->model::findWhere($query)->first())->update($data)->fresh();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * @param array $data
     * @param string $id
     * @return mixed
     */
    public function updateById(array $data, string $id) {
        try {
            return tap($this->model::where('id', $id)->first())->update($data)->fresh();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * @param array $query
     * @return mixed
     */
    public function deleteOne($query) {
        return $this->model->findWhere($query)->delete();
    }
}
