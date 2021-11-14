<?php

namespace SparkleDTO;

use JsonSerializable;
use SparkleDTO\Exceptions\ConfigurationException;
use SparkleDTO\Exceptions\UndefinedProperty;
use SparkleDTO\Traits\AliasTrait;
use SparkleDTO\Traits\ArrayTrait;
use SparkleDTO\Traits\CastTrait;
use SparkleDTO\Traits\ComputedTrait;
use ArrayAccess;

class DataTransferObject implements ArrayAccess, JsonSerializable

{
    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $data = [];

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
    }

    /**
     * @throws UndefinedProperty
     */
    public function __get($property)
    {
        if (isset($this->data[$property])) {
            return $this->data[$property];
        }
        if (isset($this->hiddenData[$property])) {
            return $this->hiddenData[$property];
        }
        throw new UndefinedProperty('Undefined property: ' . $property);
    }

    public function __set($property, $value)
    {
        if ($this->isHidden($property)) {
            $this->hiddenData[$property] = $this->castIfPrimitive($property, $value);
        } else if ($this->canBeFilled($property)) {
            $this->data[$property] = $this->castIfPrimitive($property, $value);
        }
        try {
            $this->calculateComputedProperties();
        } catch (UndefinedProperty $e) {
            // Ignore exception if setting first property
            // and invoking a computed property
        }
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
        // Trigger magit method __set() which solves casting
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }


    private function isHidden($property): bool
    {
        return in_array($property, $this->hidden);
    }

    private function canBeFilled($property): bool
    {
        return (count($this->fillable) && in_array($property, $this->fillable)) || empty($this->fillable);
    }

    public function __toString()
    {
        return json_encode($this->data);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}