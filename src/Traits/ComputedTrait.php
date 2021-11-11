<?php

namespace SparkleDTO\Traits;

trait ComputedTrait
{
    private function calculateComputedProperties()
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (str_starts_with($method, 'get') && str_ends_with($method, 'Attribute')) {
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
}
