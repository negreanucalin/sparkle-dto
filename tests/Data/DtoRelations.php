<?php
namespace SparkleDto\Tests\Data;
use SparkleDto\DataTransferObject;

class DtoRelations extends DataTransferObject
{
    protected $casts = [
        'users' => DtoRelationUsers::class,
        'children'=> DtoRelations::class,
        'single'=>DtoRelations::class,
    ];

}
