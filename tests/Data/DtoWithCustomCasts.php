<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithCustomCasts extends DataTransferObject
{
    protected $casts = [
        'a' => [DtoWithCustomCasts::class, 'castBool'],
        'b' => [DtoWithCustomCasts::class, 'castBool'],
        'c' => [DtoWithCustomCasts::class, 'castBool'],
    ];

    public static function castBool($value)
    {
        if (empty($value)) {
            return null;
        }
        return $value === 'yes';
    }
}