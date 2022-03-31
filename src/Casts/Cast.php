<?php

namespace SparkleDto\Casts;

use Carbon\Carbon;

class Cast
{
    /**
     * Cast map of custom conversions
     *
     * @var string[]
     */
    public static $castClassMap = [
        'datetime' => Carbon::class,
        'date' => Carbon::class,
    ];

    /**
     * Primitive cast map
     *
     * @var string[]
     */
    public static $castMap = [
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'int' => 'int',
        'integer' => 'int',
        'array' => 'array',
        'float' => 'float',
        'str' => 'string',
        'string' => 'string',
    ];
}