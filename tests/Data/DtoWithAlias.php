<?php
namespace SparkleDTO\Tests\Data;
use SparkleDTO\DataTransferObject;

class DtoWithAlias extends DataTransferObject
{
    protected $alias = ['b'=>'c'];
}
