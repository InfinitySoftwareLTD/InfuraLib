<?php

namespace InfinitySolutions\Infura\Traits;

trait Parameters{

    protected $params;
    protected $id;

    public function setParams(array $params): Parameters
    {
        $this->params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setId($id): Parameters
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
