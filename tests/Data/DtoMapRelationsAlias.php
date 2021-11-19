<?php
namespace SparkleDto\Tests\Data;

use SparkleDto\DataTransferObject;

class DtoMapRelationsAlias extends DataTransferObject
{
    protected $casts = [
        'users*' => DtoRelationUsersAlias::class,
        'children'=> DtoMapRelationsAlias::class
    ];

    public function getFirstUserNameAttribute()
    {
        return $this->users['first']->short_name;
    }
}
