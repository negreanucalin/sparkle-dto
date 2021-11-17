<?php

namespace SparkleDto\Tests\Stress;

use PHPUnit\Framework\TestCase;
use SparkleDto\Tests\Data\DtoMapRelations;

class StressTest extends TestCase
{
    public function test_5k_instances()
    {
        for($i=0;$i<10;$i++) {
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
            $b = $dto->first_user_name;
            echo $b;
        }

        $this->assertEquals(100000, $i);
    }
}
