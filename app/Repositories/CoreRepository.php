<?php

namespace App\Repositories;

abstract class CoreRepository
{
    protected $model;
    protected $user;

    public function __construct()
    {
        $this->model = app($this->getModel());
        $this->user = auth()->user();
    }

    abstract protected function getModel();

    protected function startInit()
    {
        return clone $this->model;
    }

}
