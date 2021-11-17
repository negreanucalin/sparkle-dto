<?php

namespace SparkleDto\Tests;

use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoWithCasts;

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
        $this->assertEquals(1, $dto->a);
        $this->assertIsNumeric($dto->b);
        $this->assertIsNumeric($dto->sum);
        $this->assertEquals(3, $dto->sum);
        $this->assertIsBool($dto->c);
        $this->assertIsBool($dto->d);
        $this->assertIsArray($dto->e);
        $this->assertIsFloat($dto->f);
        $this->assertIsString($dto->g);
    }

    public function test_cast_primitives_reset()
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

        $dto->a = '122';
        $dto->d = '1';
        $this->assertIsNumeric($dto->a);
        $this->assertEquals(122, $dto->a);
        $this->assertIsBool($dto->d);
        $this->assertTrue($dto->d);
    }
}
