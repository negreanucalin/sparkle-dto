<?php

namespace SparkleDTO\Tests;

use PHPUnit\Framework\TestCase;
use SparkleDTO\Tests\Data\DtoRelations;
use SparkleDTO\Tests\Data\DtoRelationUsers;

class DtoRelationsTest extends TestCase
{
    public function test_relations()
    {
        $dto = new DtoRelations(['users' => [['name' => 'calin'], ['name' => 'elena']]]);
        $this->assertTrue(is_array($dto->users));
        $this->assertTrue(is_array($dto['users']));
        $this->assertTrue($dto->users[0] instanceof DtoRelationUsers);
        $this->assertEquals('calin', $dto->users[0]->name);
    }

    public function test_relations_single()
    {
        $dto = new DtoRelations(
            [
                'users' => [['name' => 'calin'], ['name' => 'elena']],
                'single' => ['users' => [['name' => 'calin2'], ['name' => 'elena2']]]
            ]);
        $this->assertTrue(is_array($dto->users));
        $this->assertTrue(is_array($dto['users']));
        $this->assertTrue($dto->users[0] instanceof DtoRelationUsers);
        $this->assertEquals('calin', $dto->users[0]->name);
        $this->assertTrue($dto->single instanceof DtoRelations);
        $this->assertEquals('calin2', $dto->single->users[0]->name);
    }

    public function test_deep_relations()
    {
        $dto = new DtoRelations(
            [
                'users' => [
                    ['name' => 'calin'],
                    ['name' => 'elena']
                ],
                'children' => [
                    [
                        'users' => [
                            ['name' => 'calin2'],
                            ['name' => 'elena2']
                        ],
                        'children' => []
                    ]
                ]
            ]
        );
        $this->assertTrue(is_array($dto->children));
        $this->assertTrue(is_array($dto['children']));
        $this->assertTrue($dto->children[0]->users[0] instanceof DtoRelationUsers);
        $this->assertEquals('calin2', $dto->children[0]->users[0]->name);
    }
}