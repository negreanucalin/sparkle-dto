<?php

namespace SparkleDTO\Tests;

use PHPUnit\Framework\TestCase;
use SparkleDTO\Tests\Data\DtoWithAliasComputed;

class DtoComputedTest extends TestCase
{
    public function test_computed()
    {
        $dto = new DtoWithAliasComputed(['a' => 1, 'b' => 2]);
        $this->assertEquals(12, (string)$dto->some_name);;
    }

    public function test_computed_recompute()
    {
        $dto = new DtoWithAliasComputed(['a' => 1, 'b' => 2]);
        $dto->a = 22;
        $this->assertEquals(222, (string)$dto->some_name);
    }
}