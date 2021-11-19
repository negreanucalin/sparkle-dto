<?php

namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoRelationUsersAlias extends DataTransferObject
{
    protected $alias = ['name' => 'short_name'];
}