<?php

namespace SparkleDTO\Tests\Data;

use SparkleDTO\DataTransferObject;

class DtoWithUndefinedHidden extends DataTransferObject
{
    protected $hidden = ['a'];
}
