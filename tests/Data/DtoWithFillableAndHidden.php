<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

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