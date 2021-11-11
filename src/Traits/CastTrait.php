<?php

namespace SparkleDTO\Traits;

trait CastTrait
{
    /**
     * @var array
     */
    protected $casts = [];

    private function calculateCasts()
    {
        foreach ($this->casts as $cast => $classCast) {
            if (is_subclass_of($classCast, self::class) && isset($this->{$cast})) {
                if ($this->isSingle($this->{$cast})) {
                    $this->{$cast} = new $classCast($this->{$cast});
                } else {
                    $this->{$cast} = $classCast::hydrate($this->{$cast});
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
        foreach ($listParams as $arg) {
            $list[] = new static($arg);
        }
        return $list;
    }
}
