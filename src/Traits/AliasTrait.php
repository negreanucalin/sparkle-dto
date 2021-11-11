<?php

namespace SparkleDTO\Traits;

trait AliasTrait
{
    /**
     * @var array
     */
    protected $alias = [];

    protected function getAliasedData(array $func_get_args)
    {
        if (empty($this->alias)) {
            return $func_get_args;
        }

        foreach ($this->alias as $aliasIn => $aliasOut) {
            if (isset($func_get_args[$aliasIn])) {
                $func_get_args[$aliasOut] = $func_get_args[$aliasIn];
                unset($func_get_args[$aliasIn]);
            }
        }
        return $func_get_args;
    }
}
