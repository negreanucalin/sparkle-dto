<?php
namespace SparkleDTO\Tests\Data;
use SparkleDTO\DataTransferObject;

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
