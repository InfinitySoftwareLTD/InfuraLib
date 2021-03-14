<?php

namespace InfinitySolutions\Infura\Traits;

trait Method{

    protected $method;

    public function setMethod($method): Method
    {
        $this->method = $method;
        return $this;
    }

    protected function getMethod()
    {
        return $this->method;
    }

}