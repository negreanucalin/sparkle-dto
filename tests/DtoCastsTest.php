<?php

namespace SparkleDTO\Tests;

use PHPUnit\Framework\TestCase;
use SparkleDTO\Tests\Data\DtoWithCasts;

class DtoCastsTest extends TestCase
{
    public function test_cast_primitives()
    {
        $dto = new DtoWithCasts([
            'a'=>'1',
            'b'=>'2',
            'c'=>1,
            'd'=>0,
            'e'=>'testString',
            'f'=>'12.4',
            'g'=>1231231,
        ]);

        $this->assertIsNumeric($dto->a);
        $this->assertIsNumeric($dto->b);
        $this->assertIsNumeric($dto->sum);
        $this->assertEquals(3, $dto->sum);
        $this->assertIsBool($dto->c);
        $this->assertIsBool($dto->d);
        $this->assertIsArray($dto->e);
        $this->assertIsFloat($dto->f);
        $this->assertIsString($dto->g);
    }
}
