<?php

namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithFillable extends DataTransferObject
{
    protected $fillable = [
        'prop1',
        'prop2',
        'prop3',
    ];

}