<?php

namespace SparkleDto\Traits;

use Exception;
use SparkleDto\AttributeCacheClass;

trait ComputedTrait
{
    private function loadAttributeMethods()
    {
        if (
            !isset(AttributeCacheClass::$classAttributesDefined[$this::class]) &&
            !isset(AttributeCacheClass::$hasAttributesMap[$this::class])
        ) {
            AttributeCacheClass::$classAttributesDefined[$this::class] = $this->filterComputedMethods(get_class_methods($this));
        }
    }

    private function calculateComputedProperties()
    {
        if (!AttributeCacheClass::$hasAttributesMap[$this::class]) {
            return;
        }
        foreach (AttributeCacheClass::$classAttributesDefined[$this::class] as $method) {
            $property = AttributeCacheClass::toLowerCase(str_replace(['get', 'Attribute'], '', $method));
            try {
                $this->setProperty($property, $this->$method());
            } catch (Exception $e) {
                // Blank catch because the property
                // in dynamic attribute is not yet defined
            }
        }
    }

    private function filterComputedMethods($methods)
    {
        $methodList = [];
        AttributeCacheClass::$hasAttributesMap[$this::class] = false;
        foreach ($methods as $method) {
            if ($this->startsWith($method, 'get') && $this->endsWith($method, 'Attribute')) {
                $methodList[] = $method;
                AttributeCacheClass::$hasAttributesMap[$this::class] = true;
            }
        }
        return $methodList;
    }

    private function startsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    private function endsWith($haystack, $needle)
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}