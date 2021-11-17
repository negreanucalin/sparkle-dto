<?php

namespace SparkleDto\Tests\Unit;

use SparkleDto\DataTransferObjectWithId;
use PHPUnit\Framework\TestCase;

class DtoWithIdTest extends TestCase
{
    /**
     * A basic test example for id.
     *
     * @return void
     */
    public function test_basic()
    {
        $inData = ['a' => 1, 'b' => 2];
        $dto = new DataTransferObjectWithId($inData);
        $this->assertEquals(1, $dto->a);
        $this->assertEquals(2, $dto->b);
        $this->assertArrayHasKey('id', $dto);
        $this->assertIsString($dto['id']);
        $this->assertIsString($dto->id);
        $this->assertArrayHasKey('a', $dto);
        $this->assertArrayHasKey('b', $dto);
    }
}