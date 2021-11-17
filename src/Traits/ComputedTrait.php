<?php

namespace SparkleDto\Traits;

use Exception;

trait ComputedTrait
{
    private function loadAttributeMethods()
    {
        if (empty($this->classAttributesDefined)) {
            $this->classAttributesDefined = $this->filterComputedMethods(get_class_methods($this));
        }
    }

    private function calculateComputedProperties()
    {
        if (!$this->hasAttributes) {
            return;
        }
        foreach ($this->classAttributesDefined as $method) {
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
        foreach ($methods as $method) {
            if ($this->startsWith($method, 'get') && $this->endsWith($method, 'Attribute')) {
                $methodList[] = $method;
                $this->hasAttributes = true;
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
