<?php

namespace SparkleDto;

class AttributeCacheClass
{
    public static $hasAttributesMap = [];

    public static $classAttributesDefined = [];

    private static $checkSubclassMap = [];

    private static $checkInterfaceMap = [];

    private static $checkExistsMap = [];

    private static $checkCallable = [];

    private static $snakeCache = [];

    public static function isSubclassOf($classCast, $targetClass)
    {
        if (isset(self::$checkSubclassMap[$classCast])) {
            return self::$checkSubclassMap[$classCast];
        }
        return self::$checkSubclassMap[$classCast] = is_subclass_of($classCast, $targetClass);
    }

    public static function isSubclassOfInterface($classCast, $targetInterface)
    {
        if (isset(self::$checkInterfaceMap[$classCast])) {
            return self::$checkInterfaceMap[$classCast];
        }
        return self::$checkInterfaceMap[$classCast] = isset(class_implements($classCast, $targetInterface)[$targetInterface]);
    }

    public static function isClassDefined($classCast)
    {
        if (isset(self::$checkExistsMap[$classCast])) {
            return self::$checkExistsMap[$classCast];
        }
        return self::$checkExistsMap[$classCast] = class_exists($classCast);
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

    public static function isCallable(mixed $classCast)
    {
        if (isset(self::$checkCallable[$classCast])) {
            return self::$checkCallable[$classCast];
        }
        return self::$checkCallable[$classCast] = is_callable($classCast);
    }
}
