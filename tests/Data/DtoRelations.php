<?php
namespace SparkleDTO\Tests\Data;
use SparkleDTO\DataTransferObject;

class DtoRelations extends DataTransferObject
{
    protected $casts = [
        'users' => DtoRelationUsers::class,
        'children'=> DtoRelations::class,
        'single'=>DtoRelations::class,
    ];

}
