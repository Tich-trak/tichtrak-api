<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Http\Traits\UserDetailsTrait;

class BaseService {
    use UserDetailsTrait;

    protected $repository;
    protected string $name;

    public function __construct($repository, string $name = 'Data') {
        $this->repository = $repository;
        $this->name = $name;
    }

    public function create(array $payload) {
        $data =  $this->repository->create($payload);
        if (!$data) throw new ErrorException('unable to create ' . $this->name);

        return $data;
    }

    public function find() {
        return $this->repository->findAll();
    }

    public function findAll($query = null) {
        $data = $query ? $this->repository->findWhere($query) : $this->repository->all();
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function paginate($limit = 15) {
        $data = $this->repository->paginate($limit);
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function findById(string $key) {
        $data =  $this->repository->find($key);
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function findOne(array $query) {
        $data = $this->repository->findWhere($query)->first();
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function updateById(string $key, array $payload) {
        $data = $this->repository->updateById($payload, $key);
        if (!$data) throw new ErrorException('unable to update ' . $this->name, 404);

        return $data;
    }

    public function updateOne(array $query, array $payload) {
        $data =  $this->repository->updateOne($payload, $query);
        if (!$data) throw new ErrorException('unable to update ' . $this->name, 404);

        return $data;
    }

    public function upsert(array $query, array $payload) {
        return $this->repository->updateOrCreate($query, $payload);
    }

    public function deleteById(int $key) {
        $data = $this->repository->find($key);
        if (!$data) throw new ErrorException('cannot find ' . $this->name, 404);

        return $data->delete();
    }

    public function deleteOne(array $query) {
        return $this->repository->deleteOne($query);
    }
}
