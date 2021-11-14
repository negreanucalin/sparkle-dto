<?php

namespace SparkleDTO\Traits;

trait AliasTrait
{
    /**
     * @var array
     */
    protected $alias = [];

    protected function getAliasedData(array $arguments)
    {
        if (empty($this->alias)) {
            return $arguments;
        }

        foreach ($this->alias as $aliasIn => $aliasOut) {
            if (isset($arguments[$aliasIn])) {
                $arguments[$aliasOut] = $arguments[$aliasIn];
                unset($arguments[$aliasIn]);
            }
        }
        return $arguments;
    }
}
