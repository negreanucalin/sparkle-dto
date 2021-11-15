<?php

namespace SparkleDTO\Traits;

trait ComputedTrait
{
    private function calculateComputedProperties()
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if ($this->startsWith($method, 'get') && $this->endsWith($method, 'Attribute')) {
                $property = $this->toLowerCase(
                    str_replace(['get', 'Attribute'], '', $method)
                );
                $this->{$property} = $this->$method();
            }
        }
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
