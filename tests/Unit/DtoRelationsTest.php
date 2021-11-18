<?php

namespace SparkleDto\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoMapRelations;
use SparkleDto\Tests\Data\DtoRelations;
use SparkleDto\Tests\Data\DtoRelationUsers;

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

    public function test_deep_map_relations()
    {
        $dto = new DtoMapRelations(
            [
                'users' => [
                    'first'=>['name' => 'calin'],
                    'second'=>['name' => 'elena']
                ],
                'children' => [
                    [
                        'users' => [
                            '4th'=>['name' => 'calin2'],
                            '5th'=>['name' => 'elena2']
                        ],
                        'children' => []
                    ]
                ]
            ]
        );
        $this->assertTrue(is_array($dto->children));
        $this->assertTrue(is_array($dto['children']));
        $this->assertTrue($dto->children[0]->users['4th'] instanceof DtoRelationUsers);
        $this->assertEquals('calin2', $dto->children[0]->users['4th']->name);
        $this->assertEquals('calin', $dto->first_user_name);
    }
}