<?php

namespace SparkleDto\Traits;

trait ArrayTrait
{
    public function offsetExists($propertyName)
    {
        return isset($this->data[$propertyName]);
    }

    public function offsetGet($propertyName)
    {
        return isset($this->data[$propertyName]) ? $this->data[$propertyName] : null;
    }

    public function offsetSet($propertyName, $value)
    {

    }

    public function offsetUnset($propertyName)
    {

    }
}
