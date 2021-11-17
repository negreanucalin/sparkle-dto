<?php

namespace SparkleDto\Tests\Stress;

use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoMapRelations;

class StressTest extends TestCase
{
    public function test_100k_instances()
    {
        for($i=0;$i<100000;$i++) {
            $dto = new DtoMapRelations(
                [
                    'users' => [
                        'first' => ['name' => 'calin'],
                        'second' => ['name' => 'elena']
                    ],
                    'children' => [
                        [
                            'users' => [
                                '4th' => ['name' => 'calin2'],
                                '5th' => ['name' => 'elena2']
                            ]
                        ]
                    ]
                ]
            );
        }

        $this->assertEquals(100000, $i);
    }

    public function test_50k_instances()
    {
        for($i=0;$i<50000;$i++) {
            $dto = new DtoMapRelations(
                [
                    'users' => [
                        'first' => ['name' => 'calin'],
                        'second' => ['name' => 'elena']
                    ],
                    'children' => [
                        [
                            'users' => [
                                '4th' => ['name' => 'calin2'],
                                '5th' => ['name' => 'elena2']
                            ]
                        ]
                    ]
                ]
            );
        }

        $this->assertEquals(50000, $i);
    }
}
