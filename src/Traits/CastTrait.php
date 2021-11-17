<?php

namespace SparkleDto\Traits;

trait CastTrait
{
    /**
     * @var array
     */
    protected $casts = [];

    private $castMap = [
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'int' => 'int',
        'integer' => 'int',
        'array' => 'array',
        'float' => 'float',
        'str' => 'string',
        'string' => 'string',
    ];

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
     * Compute casts defined in the DTO
     * Triggers re-computation of custom getters
     */
    private function calculateCasts()
    {
        foreach ($this->casts as $property => $classCast) {
            $isMapCast = $this->isMapCast($property);
            $property = $this->getProperty($property);
            if (
                is_subclass_of($classCast, self::class) // Only children of DTO allowed
                && (isset($this->data[$property]) || isset($this->hiddenData[$property]))) {
                if ($this->isSingle($this->{$property}) && !$isMapCast) {
                    $this->{$property} = new $classCast($this->{$property});
                } else {
                    $this->{$property} = $classCast::hydrate($this->{$property});
                }
            }
        }
    }

    /**
     * Determines if we should hydrate the relation as a map
     * @param $propertyName
     * @return bool
     */
    public function isMapCast($propertyName)
    {
        return $this->startsWith($propertyName, self::CAST_MAP_IDENTIFIER) ||
            $this->endsWith($propertyName, self::CAST_MAP_IDENTIFIER);
    }

    /**
     * Return the property name without the "map" identifier
     * @param $propertyName
     * @return array|string
     */
    private function getProperty($propertyName)
    {
        return str_replace(self::CAST_MAP_IDENTIFIER, "", $propertyName);
    }

    /**
     * Assume if we have numeric keys that we have many related
     * @param array $relatedData
     * @return bool
     */
    private function isSingle(array $relatedData)
    {
        return !isset($relatedData[0]);
    }

    /**
     * Return a list of DTO's (numeric or string keys a.k.a maps)
     * @param $listParams
     * @return array
     */
    public static function hydrate($listParams): array
    {
        $list = [];
        foreach ($listParams as $key => $arg) {
            $list[$key] = new static($arg);
        }
        return $list;
    }
}
