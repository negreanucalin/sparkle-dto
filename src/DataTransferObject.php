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

    /**
     * @var array
     */
    protected $casts = [];

    private $castMap = [
        'bool'=>'boolean',
        'boolean'=>'boolean',
        'int'=>'int',
        'integer'=>'int',
        'array'=>'array',
        'float'=>'float',
        'str'=>'string',
        'string'=>'string',
    ];

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
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     */
    private function castIfPrimitive(string $propertyName, mixed $value): mixed
    {
        // Is defined as primitive
        if (isset($this->casts[$propertyName]) && isset($this->castMap[$this->casts[$propertyName]])) {
            settype($value, $this->castMap[$this->casts[$propertyName]]);
        }
        return $value;
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
        if ($this->isHidden($property)) {
            $this->hiddenData[$property] = $this->castIfPrimitive($property, $value);
        } else if ($this->canBeFilled($property)) {
            $this->{$property} = $this->castIfPrimitive($property, $value);
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
        return json_encode($this);
    }
}
