<?php

namespace SparkleDTO\Tests;

use SparkleDTO\DataTransferObject;
use SparkleDTO\Exceptions\UndefinedDTOProperty;
use PHPUnit\Framework\TestCase;
use SparkleDTO\Tests\Data\DtoRelations;
use SparkleDTO\Tests\Data\DtoRelationUsers;
use SparkleDTO\Tests\Data\DtoWithAlias;
use SparkleDTO\Tests\Data\DtoWithAliasComputed;
use SparkleDTO\Tests\Data\DtoWithHidden;

/**
 * Ideas:
 * - Cast attributes with explicit hydration, ex: users:array, users:map, users:single
 * - Hidden properties: Maybe revise to hide from direct access?
 * - Recompute if data is reassigned?
 */


class DtoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_basic()
    {
        $inData = ['a' => 1, 'b' => 2];
        $dto = new DataTransferObject($inData);
        $this->assertEquals(json_encode($inData), (string)$dto);
        $this->assertEquals(1, $dto->a);
        $this->assertEquals(2, $dto->b);
    }

    public function test_aliased()
    {
        $this->expectException(UndefinedDTOProperty::class);
        $expectedData = ['a' => 1, 'c' => 2];
        $dto = new DtoWithAlias(['a' => 1, 'b' => 2]);
        $this->assertEquals(json_encode($expectedData), (string)$dto);
        $this->assertEquals(2, $dto->c);
        $fail = $dto->b; // Exception
    }

    public function test_hydrate()
    {
        $expectedData = ['a' => 1, 'c' => 2];
        $dto = DtoWithAlias::hydrate([
            ['a' => 1, 'b' => 2],
            ['a' => 1, 'b' => 2]
        ]);
        $this->assertEquals(json_encode($expectedData), (string)$dto[0]);
        $this->assertEquals(json_encode($expectedData), (string)$dto[1]);
    }

    public function test_computed()
    {
        $dto = new DtoWithAliasComputed(['a' => 1, 'b' => 2]);
        $this->assertEquals(12, (string)$dto->some_name);
    }

    public function test_relations()
    {
        $dto = new DtoRelations(['users' => [['name' => 'calin'], ['name' => 'elena']]]);
        $this->assertTrue(is_array($dto->users));
        $this->assertTrue(is_array($dto['users']));
        $this->assertTrue($dto->users[0] instanceof DtoRelationUsers);
        $this->assertEquals('calin', $dto->users[0]->name);
    }

    public function test_dynamic_set()
    {
        $dto = new DtoRelations(['users' => [['name' => 'calin'], ['name' => 'elena']]]);
        $dto->something = ['x'=>1];
        $this->assertEquals(['x'=>1], $dto->something);
    }

    public function test_dynamic_set_recalculate_computed()
    {
        $this->markTestSkipped('To implement: Recompute if data changes?');
    }

    public function test_relations_single()
    {
        $dto = new DtoRelations(
            [
                'users' => [['name' => 'calin'], ['name' => 'elena']],
                'single'=>['users'=>[['name' => 'calin2'], ['name' => 'elena2']]]
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
                        'children'=>[]
                    ]
                ]
            ]
        );
        $this->assertTrue(is_array($dto->children));
        $this->assertTrue(is_array($dto['children']));
        $this->assertTrue($dto->children[0]->users[0] instanceof DtoRelationUsers);
        $this->assertEquals('calin2', $dto->children[0]->users[0]->name);
    }

    public function test_hidden_attributes()
    {
        $dto = new DtoWithHidden(['a'=>1, 'b'=>2]);
        // We let the user still access hidden data
        // To not allow him we will need to set data as protected
        // And exclude from serialization
        $fail = $dto->a;
        $this->assertArrayHasKey('b', $dto);
        $this->assertArrayHasKey('c', $dto);
        $this->assertArrayNotHasKey('a', $dto);
    }
}
