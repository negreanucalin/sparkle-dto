<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithDateCasts extends DataTransferObject
{
    protected $casts = [
        'g'=>'datetime',
    ];

    protected $dates = [
        'a',
    ];
}