<?php

namespace SparkleDto\Traits;

use Exception;

trait ComputedTrait
{
    private function loadAttributeMethods()
    {
        if (empty(self::$classAttributesDefined[$this::class])) {
            self::$classAttributesDefined[$this::class] = $this->filterComputedMethods(get_class_methods($this));
        }
    }

    private function calculateComputedProperties()
    {
        if (!self::$hasAttributesMap[$this::class]) {
            return;
        }
        foreach (self::$classAttributesDefined[$this::class] as $method) {
            $property = $this->toLowerCase(str_replace(['get', 'Attribute'], '', $method));
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
        self::$hasAttributesMap[$this::class] = false;
        foreach ($methods as $method) {
            if ($this->startsWith($method, 'get') && $this->endsWith($method, 'Attribute')) {
                $methodList[] = $method;
                self::$hasAttributesMap[$this::class] = true;
            }
        }
        return $methodList;
    }

    private function toLowerCase($string)
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
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