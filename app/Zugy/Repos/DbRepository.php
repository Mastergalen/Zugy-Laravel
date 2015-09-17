<?php

namespace Zugy\Repos;

abstract class DbRepository
{
    public function find($id) {
        return $this->model->findOrFail($id);
    }
}