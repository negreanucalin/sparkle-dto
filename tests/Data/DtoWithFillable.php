<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithFillable extends DataTransferObject
{
    protected $fillable = [
        'prop1',
        'prop2',
        'prop3',
    ];

}