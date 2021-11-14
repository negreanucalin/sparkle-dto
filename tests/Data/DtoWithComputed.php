<?php
namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithComputed extends DataTransferObject
{

    public function getSomeNameAttribute(): string
    {
        return $this->a . $this->b;
    }
}
