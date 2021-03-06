<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithCasts extends DataTransferObject
{
    protected $casts = [
        'a'=>'int',
        'b'=>'integer',
        'c'=>'boolean',
        'd'=>'bool',
        'e'=>'array',
        'f'=>'float',
        'g'=>'string',
    ];

    function getSumAttribute()
    {
        return $this->a + $this->b;
    }
}