<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithComputed extends DataTransferObject
{

    public function getSomeNameAttribute(): string
    {
        return $this->a . $this->b;
    }

    public function getSomeName2Attribute(): string
    {
        return $this->b . $this->a;
    }
}
