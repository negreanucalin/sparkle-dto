<?php

namespace SparkleDTO;

use SparkleDTO\Exceptions\UndefinedDTOProperty;
use SparkleDTO\Traits\AliasTrait;
use SparkleDTO\Traits\ArrayTrait;
use SparkleDTO\Traits\CastTrait;
use SparkleDTO\Traits\ComputedTrait;
use ArrayAccess;

class DataTransferObject implements ArrayAccess
{
    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    private $hiddenData = [];

    use AliasTrait;
    use CastTrait;
    use ComputedTrait;
    use ArrayTrait;

    public function __construct($arguments)
    {
        $this->assignData(
            $this->getAliasedData($arguments)
        );
        $this->calculateCasts();
        $this->calculateComputedProperties();
    }

    private function assignData($data)
    {
        foreach ($data as $property=>$value) {
            if (in_array($property, $this->hidden)) {
                $this->hiddenData[$property] = $value;
            } else {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * @throws UndefinedDTOProperty
     */
    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        if (isset($this->hiddenData[$name])) {
            return $this->hiddenData[$name];
        }

        throw new UndefinedDTOProperty('Undefined property: ' . $name);
    }

    public function __set($property, $value)
    {
        if (in_array($property, $this->hidden)) {
            $this->hiddenData[$property] = $value;
        } else {
            $this->{$property} = $value;
        }
    }

    public function __toString()
    {
        return json_encode($this);
    }

    public function hasProperty($string)
    {
        return property_exists($this,$string);
    }
}
