<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoWithUndefinedHidden extends DataTransferObject
{
    protected $hidden = ['a'];
}
