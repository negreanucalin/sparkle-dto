<?php

namespace SparkleDTO\Tests;

use SparkleDTO\DataTransferObjectWithId;
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
        $this->assertArrayHasKey('a', $dto);
        $this->assertArrayHasKey('b', $dto);
    }
}