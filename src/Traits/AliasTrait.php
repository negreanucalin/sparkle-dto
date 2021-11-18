<?php

namespace SparkleDto\Traits;

trait AliasTrait
{
    /**
     * @var array
     */
    protected $alias = [];

    /**
     * Upon creating the class instance we check aliased members and rename them internally
     *
     * @param array $arguments
     * @return array
     */
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
