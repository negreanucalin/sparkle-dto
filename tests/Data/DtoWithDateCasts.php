<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithDateCasts extends DataTransferObject
{
    protected $casts = [
        'date2'=>'datetime',
    ];

    protected $dates = [
        'a'
    ];
}