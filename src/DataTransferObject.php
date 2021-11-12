<?php

namespace SparkleDTO;

use SparkleDTO\Exceptions\ConfigurationException;
use SparkleDTO\Exceptions\UndefinedProperty;
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

    /**
     * @var array
     */
    protected $fillable = [];

    use AliasTrait;
    use CastTrait;
    use ComputedTrait;
    use ArrayTrait;

    /**
     * @param $arguments
     */
    public function __construct($arguments)
    {
        $this->validateConfiguration();
        $this->assignData(
            $this->getAliasedData($arguments)
        );
        $this->calculateCasts();
        $this->calculateComputedProperties();
    }

    /**
     * @throws ConfigurationException
     */
    private function validateConfiguration()
    {
        if (count($this->hidden) && count($this->fillable)) {
            throw new ConfigurationException('Hidden attributes and fillable defined, choose one strategy');
        }
    }

    private function assignData($data)
    {
        foreach ($data as $property=>$value) {
            if (count($this->hidden) && in_array($property, $this->hidden)) {
                $this->hiddenData[$property] = $value;
            } else {
                if ((count($this->fillable) && in_array($property, $this->fillable)) || empty($this->fillable)) {
                    $this->{$property} = $value;
                }
            }
        }
    }

    /**
     * @throws UndefinedProperty
     */
    public function __get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
        if (isset($this->hiddenData[$name])) {
            return $this->hiddenData[$name];
        }

        throw new UndefinedProperty('Undefined property: ' . $name);
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
