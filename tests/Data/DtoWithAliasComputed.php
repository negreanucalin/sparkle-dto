<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithAliasComputed extends DataTransferObject
{
    protected $alias = ['b'=>'c'];

    public function getSomeNameAttribute(): string
    {
        return $this->a . $this->c;
    }
}
