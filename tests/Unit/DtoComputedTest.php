<?php

namespace SparkleDto\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoWithAliasComputed;
use SparkleDto\Tests\Data\DtoWithComputed;

class DtoComputedTest extends TestCase
{
    public function test_computed()
    {
        $dto = new DtoWithAliasComputed(['a' => 1, 'b' => 2]);
        $this->assertEquals(12, (string)$dto->some_name);
    }

    public function test_computed_recompute()
    {
        $dto = new DtoWithComputed(['a' => 1, 'b' => 9]);
        $this->assertEquals(19, (string)$dto->some_name);
        $dto->a = 24;
        $this->assertEquals(249, (string)$dto->some_name);
        $this->assertEquals(924, (string)$dto->some_name2);
    }

    public function test_computed_recompute2()
    {
        $data = [
            ['a' => 1, 'b' => 9]
        ];

        $dto = DtoWithComputed::hydrate($data);
        $this->assertEquals(19, (string)$dto[0]->some_name);
        $dto[0]->a = 24;
        $this->assertEquals(249, (string)$dto[0]->some_name);
        $this->assertEquals(924, (string)$dto[0]->some_name2);
    }
}