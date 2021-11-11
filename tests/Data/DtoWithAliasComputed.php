<?php
namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithAliasComputed extends DataTransferObject
{
    protected $alias = ['b'=>'c'];

    public function getSomeNameAttribute(): string
    {
        return $this->a . $this->c;
    }
}
