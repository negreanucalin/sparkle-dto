<?php
namespace SparkleDto\Tests\Data;
use SparkleDto\DataTransferObject;

class DtoWithAlias extends DataTransferObject
{
    protected $alias = ['b'=>'c'];
}
