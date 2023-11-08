<?php

namespace App\Tests\Entity;

use App\Entity\Measurement;
use PHPUnit\Framework\TestCase;

class MeasurementTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5',32.9],
            ['15.5',59.9],
            ['13',55.4],
            ['75.5',167.9],
            ['22.2',71.96],
            ['2.8',37.04],
            ['3.1',37.58],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);
        $this->assertEquals($expectedFahrenheit,$measurement->getFahrehneit());

        /*
        $measurement->setCelsius('0');
        $this->assertEquals(32, $measurement->getFahrehneit());

        $measurement->setCelsius('-100');
        $this->assertEquals(-148, $measurement->getFahrehneit());

        $measurement->setCelsius('100');
        $this->assertEquals(212, $measurement->getFahrehneit());
        */

    }
}
