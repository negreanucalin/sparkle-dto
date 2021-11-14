<?php

namespace SparkleDTO\Tests;

use SparkleDTO\DataTransferObject;
use SparkleDTO\Exceptions\UndefinedProperty;
use PHPUnit\Framework\TestCase;
use SparkleDTO\Tests\Data\DtoRelations;
use SparkleDTO\Tests\Data\DtoWithAlias;
use SparkleDTO\Tests\Data\DtoWithFillable;

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
        $expectedData = ['a' => 1, 'c' => 2];
        $dto = new DtoWithAlias(['a' => 1, 'b' => 2]);
        $this->assertEquals(json_encode($expectedData), (string)$dto);
        $this->assertEquals(2, $dto->c);
    }

    public function test_aliased_exception() {
        $this->expectException(UndefinedProperty::class);
        $dto = new DtoWithAlias(['a' => 1, 'b' => 2]);
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

    public function test_dynamic_set()
    {
        $dto = new DtoRelations(['users' => [['name' => 'calin'], ['name' => 'elena']]]);
        $dto->something = ['x' => 1];
        $this->assertEquals(['x' => 1], $dto->something);
    }

    public function test_fillable_properties()
    {
        $dto = new DtoWithFillable([
            'prop1' => 1,
            'prop2' => 2,
            'prop3' => 3,
            'prop4' => 4,
            'prop5' => 5,
        ]);
        $this->assertArrayHasKey('prop1', $dto);
        $this->assertArrayHasKey('prop2', $dto);
        $this->assertArrayHasKey('prop3', $dto);
        $this->assertArrayNotHasKey('prop4', $dto);
        $this->assertArrayNotHasKey('prop5', $dto);
    }
}