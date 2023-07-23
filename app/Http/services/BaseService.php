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

    public function findById(int $key) {
        $data =  $this->repository->find($key);
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function findOne(array $query) {
        $data = $this->repository->findWhere($query)->first();
        if (!$data) throw new ErrorException('unable to fetch ' . $this->name, 404);

        return $data;
    }

    public function updateOne(int $key, array $payload) {
        $data = $this->repository->find($key);
        if (!$data) throw new ErrorException('cannot find ' . $this->name, 404);

        return $data->update($payload);
    }

    public function upsert(array $query, array $payload) {
        return  $this->repository->updateOrCreate($query, $payload);
    }

    public function deleteOne(int $key) {
        $data = $this->repository->find($key);
        if (!$data) throw new ErrorException('cannot find ' . $this->name, 404);

        return $data->delete();
    }
}