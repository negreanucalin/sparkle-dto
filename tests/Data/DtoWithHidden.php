<?php

namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithHidden extends DataTransferObject
{
    protected $hidden = ['a'];

    /**
     * Replace a with z
     * @return mixed
     */
    public function getCAttribute()
    {
        return $this->a;
    }
}
