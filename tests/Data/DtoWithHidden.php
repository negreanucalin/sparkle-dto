<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

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
