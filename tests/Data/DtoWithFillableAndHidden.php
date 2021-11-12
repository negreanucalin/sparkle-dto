<?php

namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithFillableAndHidden extends DataTransferObject
{
    protected $fillable = [
        'prop1',
        'prop2',
        'prop3',
    ];

    protected $hidden = [
        'prop5'
    ];

}