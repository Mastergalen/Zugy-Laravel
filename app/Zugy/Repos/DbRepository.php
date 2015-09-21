<?php

namespace Zugy\Repos;

abstract class DbRepository
{
    public function find($id) {
        return $this->model->findOrFail($id);
    }

    public function all() {
        return $this->model->all();
    }

    public function paginate($perPage) {
        return $this->model->paginate($perPage);
    }
}