<?php

namespace SparkleDto;

use JsonSerializable;
use SparkleDto\Exceptions\ConfigurationException;
use SparkleDto\Traits\AliasTrait;
use SparkleDto\Traits\ArrayTrait;
use SparkleDto\Traits\CastTrait;
use SparkleDto\Traits\ComputedTrait;
use ArrayAccess;

class DataTransferObject implements ArrayAccess, JsonSerializable
{
    /**
     * Identifier at the start or end of the string key (casts)
     * If exists then we try to hydrate a DTO list resulting
     * in a map which is very useful
     */
    const CAST_MAP_IDENTIFIER = "*";

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
            $this->getAliasedData(
                $this->appendEmptyFillable($arguments)
            )
        );
        $this->calculateCasts();
    }

    private function appendEmptyFillable($propertyMap): array
    {
        $difference = array_diff(array_merge($this->fillable, array_keys($this->casts)), array_keys($propertyMap));
        foreach ($difference as $missingKey) {
            $propertyMap[$missingKey] = null;
        }
        return $propertyMap;
    }

    public function &__get($property)
    {
        $value = null;
        if (isset($this->data[$property])) {
            $value = $this->data[$property];
        }
        if (isset($this->hiddenData[$property])) {
            $value = $this->hiddenData[$property];
        }
        return $value;
    }

    public function __set($property, $value)
    {
        if ($this->isHidden($property)) {
            $this->hiddenData[$property] = $this->castIfPrimitive($property, $value);
        } else if ($this->canBeFilled($property)) {
            $this->data[$property] = $this->castIfPrimitive($property, $value);
        }
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

    public function hasProperty($propertyName)
    {
        return $this->{$propertyName} !== null;
    }
}