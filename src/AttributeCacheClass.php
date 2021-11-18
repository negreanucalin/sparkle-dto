<?php

namespace SparkleDto;

class AttributeCacheClass
{
    public static $hasAttributesMap = [];

    public static $classAttributesDefined = [];

    private static $checkSubclassMap = [];

    private static $snakeCache = [];

    public static function isSubclassOf($classCast, $targetClass)
    {
        if (isset(self::$checkSubclassMap[$classCast])) {
            return self::$checkSubclassMap[$classCast];
        }
        return self::$checkSubclassMap[$classCast] = is_subclass_of($classCast, $targetClass);
    }

    public static function toLowerCase($string)
    {
        if(isset(self::$snakeCache[$string])) {
            return self::$snakeCache[$string];
        }
        return self::$snakeCache[$string] = strtolower(
            preg_replace(
                ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'],
                '$1_$2',
                $string
            )
        );
    }
}