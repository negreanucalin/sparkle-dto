<?php

namespace SparkleDto\Tests;

use SparkleDto\Exceptions\ConfigurationException;
use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoWithFillableAndHidden;
use SparkleDto\Tests\Data\DtoWithHidden;
use SparkleDto\Tests\Data\DtoWithUndefinedHidden;

class DtoHiddenTest extends TestCase
{
    public function test_hidden_attributes()
    {
        $dto = new DtoWithHidden(['a'=>1, 'b'=>2]);
        // We let the user still access hidden data
        // To not allow him we will need to set data as protected
        // And exclude from serialization
        $this->assertArrayHasKey('b', $dto);
        $this->assertArrayHasKey('c', $dto);
        $this->assertArrayNotHasKey('a', $dto);
    }

    public function test_fillable_hidden_exception()
    {
        $this->expectException(ConfigurationException::class);
        new DtoWithFillableAndHidden([
            'prop1'=>1,
            'prop2'=>2,
            'prop3'=>3,
            'prop4'=>4,
            'prop5'=>5,
        ]);
    }

    public function test_undefined_hidden()
    {
        $dto = new DtoWithUndefinedHidden(['b'=>1]);
        $this->assertArrayHasKey('b', $dto);
    }
}
