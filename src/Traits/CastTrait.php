<?php

namespace SparkleDTO\Traits;

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

    private function calculateCasts()
    {
        foreach ($this->casts as $property => $classCast) {
            if (is_subclass_of($classCast, self::class) && isset($this->data[$property])) {
                if ($this->isSingle($this->{$property})) {
                    if ($this->isHidden($property)) {
                        $this->hiddenData[$property] = new $classCast($this->{$property});
                    } else {
                        $this->{$property} = new $classCast($this->{$property});
                    }
                } else {
                    if ($this->isHidden($property)) {
                        $this->hiddenData[$property] = $classCast::hydrate($this->{$property});
                    } else {
                        $this->{$property} = $classCast::hydrate($this->{$property});
                    }
                }
            }
        }
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

    public static function hydrate($listParams): array
    {
        $list = [];
        foreach ($listParams as $key => $arg) {
            $list[$key] = new static($arg);
        }
        return $list;
    }
}
