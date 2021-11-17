<?php
namespace SparkleDto\Tests\Data;
use SparkleDto\DataTransferObject;

class DtoMapRelations extends DataTransferObject
{
    protected $casts = [
        'users*' => DtoRelationUsers::class,
        'children'=> DtoMapRelations::class
    ];

    public function getFirstUserNameAttribute()
    {
        return $this->users['first']->name;
    }
}
